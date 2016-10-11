<?php

namespace Cothema\OpeningHours;

use Cothema\OpeningHours\Exception\NotYetImplemented;
use Cothema\OpeningHours\Model\Status as StatusModel;
use Nette\Utils\DateTime;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Status extends \Nette\Object {

    /** @var \Cothema\OpeningHours\Model\OpeningHours */
    private $openingHours;

    /** @var \Nette\Utils\DateTime */
    private $time;

    /** @var string */
    private $warningClosingDiff;

    /** @var string */
    private $warningOpeningDiff;

    /**
     * 
     * @param \App\Components\OpeningHours\Model\OpeningHours $openingHours
     */
    public function __construct(Model\OpeningHours $openingHours) {
        $this->openingHours = $openingHours;
        $this->warningClosingDiff = '+2 hours';
        $this->warningOpeningDiff = '+2 hours';
        $this->time = new DateTime();
    }

    /**
     * 
     * @return string|boolean
     */
    public function getClosingAtWarning() {
        $time = new DateTime($this->time);

        $status = $this->getStatus();
        if ($status instanceof StatusModel\Opened && !$this->isOpenedByTime($time->modify($this->warningClosingDiff))) {
            return $this->closingAtByWeekDay($status->getResolver()->getDayNumber());
        }

        return FALSE;
    }

    /**
     * 
     * @return string|boolean
     */
    public function getOpeningAtWarning() {
        $timeModified = new DateTime($this->time);
        $timeModified->modify($this->warningOpeningDiff);

        $status = $this->getStatus();
        if ($status instanceof StatusModel\Closed && $this->isOpenedByTime($timeModified)) {
            return $this->openingAtByWeekDay($timeModified->format('w'));
        }

        return FALSE;
    }

    /**
     * 
     * @return \Cothema\OpeningHours\Model\Status\I\Status
     */
    public function getStatus() {
        return $this->getStatusByTime($this->time);
    }

    /**
     * 
     * @param DateTime $time
     * @return \Cothema\OpeningHours\Model\Status\I\Status
     */
    public function getStatusByTime(DateTime $time) {
        $days = ['', '-1 day']; // DateTime modifiers

        foreach ($days as $day) {
            $iStatus = $this->getStatusByTimeInDay($time, $day);

            if ($iStatus instanceof StatusModel\Opened || $iStatus instanceof StatusModel\OpenedWithTags) {
                $status = $iStatus;
                break;
            }
        }

        if (!isset($status)) {
            $status = new StatusModel\Closed();
        }

        return $status;
    }

    /**
     * 
     * @return \Nette\Utils\DateTime
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * 
     * @return string
     */
    public function getWarningClosingDiff() {
        return $this->warningClosingDiff;
    }

    /**
     * 
     * @return string
     */
    public function getWarningOpeningDiff() {
        return $this->warningOpeningDiff;
    }

    /**
     * 
     * @return boolean
     */
    public function isOpened() {
        return $this->isOpenedByTime($this->time);
    }

    /**
     * 
     * @param \Nette\Utils\DateTime $time
     */
    public function isOpenedByTime(DateTime $time) {
        $status = $this->getStatusByTime($time);

        if ($status instanceof StatusModel\Opened) {
            return TRUE;
        } elseif ($status instanceof StatusModel\Closed) {
            return FALSE;
        }

        return NULL;
    }

    /**
     * 
     * @param \Nette\Utils\DateTime $timeFrom
     * @param \Nette\Utils\DateTime $timeTo
     * @throws NotYetImplemented
     * @return boolean
     */
    public function isOpenedByTimeRange(DateTime $timeFrom, DateTime $timeTo) {
        throw new NotYetImplemented();
    }

    /**
     * 
     * @return boolean
     */
    public function isClosedNonstop() {
        return $this->openingHours->isClosedNonstop();
    }

    /**
     * 
     * @return boolean
     */
    public function isOpenedNonstop() {
        return $this->openingHours->isOpenedNonstop();
    }

    /**
     * 
     * @param \Nette\Utils\DateTime $time
     */
    public function setTime(DateTime $time) {
        $this->time = $time;
    }

    /**
     * 
     * @param string $diff
     */
    public function setWarningClosingDiff($diff) {
        $this->warningClosingDiff = $diff;
    }

    /**
     * 
     * @param string $diff
     */
    public function setWarningOpeningDiff($diff) {
        $this->warningOpeningDiff = $diff;
    }

    /**
     * 
     * @return string
     */
    private function closingAtByWeekDay($day) {
        $closing = $this->getTimeMidnight()->modify($this->openingHours->getWeekDay($day)->getCloseTime());
        return $closing->format('H:i');
    }

    /**
     * 
     * @return string
     */
    private function openingAtByWeekDay($day) {
        $opening = $this->getTimeMidnight()->modify($this->openingHours->getWeekDay($day)->getOpenTime());
        return $opening->format('H:i');
    }

    /**
     * 
     * @param \Nette\Utils\DateTime $time
     * @param string $modify
     * @return StatusModel\I\Status
     */
    private function getStatusByTimeInDay(DateTime $time, $modify = '') {
        $day = (new DateTime($time))->modify($modify . ' ' . 'midnight');
        $openingHours = $this->openingHours->getDay($day);
        if ($openingHours === NULL) {
            return new StatusModel\Closed;
        }

        $todayOpen = $this->getTimeMidnight()->modify($modify . ' ' . $openingHours->getOpenTime());
        $todayClose = $this->getTimeMidnight()->modify($modify . ' ' . $openingHours->getCloseTime());

        if (($time >= $todayOpen && $time < $todayClose)) {
            $tags = $openingHours->tags;
            if (count($tags)) {
                $status = new StatusModel\OpenedWithTags;
                $status->setTags($tags);
            } else {
                $status = new StatusModel\Opened;
            }
        } else {
            $status = new StatusModel\Closed;
        }

        $resolver = new Resolver\WeekDay();
        $resolver->setDayNumber($day->format('w'));
        $status->setResolver($resolver);

        return $status;
    }

    /**
     * 
     * @return \Nette\Utils\DateTime
     */
    private function getTimeMidnight() {
        return (new DateTime($this->time))->setTime('00', '00', '00');
    }

}
