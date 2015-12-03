<?php

namespace Cothema\OpeningHours;

use \Nette\Utils\DateTime;

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

    /**
     * 
     * @param \App\Components\OpeningHours\Model\OpeningHours $openingHours
     */
    public function __construct(Model\OpeningHours $openingHours) {
        $this->openingHours = $openingHours;
        $this->warningClosingDiff = '+2 hours';
        $this->time = new DateTime();
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
     * @return boolean
     */
    public function isOpened() {
        return $this->isOpenedByTime($this->time);
    }

    /**
     * 
     * @return boolean
     */
    public function isOpenedNonstop() {
        $days = ['0', '1', '2', '3', '4', '5', '6'];
        foreach ($days as $day) {
            $openingHours = $this->openingHours->getWeekDay($day);
            if (!($openingHours->getOpenTime('00:00') && $openingHours->getCloseTime('00:00'))) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * 
     * @param \Nette\Utils\DateTime $time
     */
    public function isOpenedByTime(DateTime $time) {
        $status = $this->getStatusByTime($time);

        if ($status instanceof Status\Opened) {
            return TRUE;
        } elseif ($status instanceof Status\Closed) {
            return FALSE;
        }

        return NULL;
    }

    /**
     * 
     * @param \Nette\Utils\DateTime $timeFrom
     * @param \Nette\Utils\DateTime $timeTo
     * @return boolean
     */
    public function isOpenedByTimeRange(DateTime $timeFrom, DateTime $timeTo) {
        throw new \Exception('Not yet implemented!');
    }

    /**
     * 
     * @return \Cothema\OpeningHours\Status\I\Status
     */
    public function getStatus() {
        return $this->getStatusByTime($this->time);
    }

    /**
     * 
     * @param DateTime $time
     * @return \Cothema\OpeningHours\Status\I\Status
     */
    public function getStatusByTime(DateTime $time) {
        $days = ['', '-1 day']; // DateTime modifiers

        foreach ($days as $day) {
            $iStatus = $this->getStatusByTimeInDay($time, $day);

            if ($iStatus instanceof Status\Opened) {
                $status = $iStatus;
                break;
            }
        }

        if (!isset($status)) {
            $status = new Status\Closed();
        }

        return $status;
    }

    /**
     * 
     * @param \Nette\Utils\DateTime $time
     * @param string $modify
     */
    private function getStatusByTimeInDay(DateTime $time, $modify = '') {
        $day = (new DateTime($time))->modify($modify . ' ' . 'midnight');
        $openingHours = $this->openingHours->getDay($day);
        if ($openingHours === NULL) {
            return new Status\Closed;
        }

        $todayOpen = $this->getTimeMidnight()->modify($modify . ' ' . $openingHours->getOpenTime());
        $todayClose = $this->getTimeMidnight()->modify($modify . ' ' . $openingHours->getCloseTime());

        if (($time >= $todayOpen && $time < $todayClose)) {
            $status = new Status\Opened;
        } else {
            $status = new Status\Closed;
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

    /**
     * 
     * @return string|boolean
     */
    public function getClosingAtWarning() {
        $time = new DateTime($this->time);

        $status = $this->getStatus();
        if ($status instanceof \Cothema\OpeningHours\Status\Opened && !$this->isOpenedByTime($time->modify('+2 hours'))) {
            return $this->closingAtByWeekDay($status->getResolver()->getDayNumber());
        }

        return FALSE;
    }

}
