<?php

namespace Cothema\OpeningHours;

use \Nette\Utils\DateTime;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Status extends \Nette\Object {

    /** @var \Cothema\OpeningHours\Model\OpeningHours */
    private $model;

    /** @var \Nette\Utils\DateTime */
    private $time;

    /** @var string */
    private $warningClosingDiff;

    /**
     * 
     * @param \App\Components\OpeningHours\Model\OpeningHours $model
     */
    public function __construct(Model\OpeningHours $model) {
        $this->model = $model;
        $this->warningClosingDiff = '+2 hours';
        $this->time = new DateTime();
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
        $openingHours = $this->model->getDay($day->format('w'));

        $todayOpen = $this->getTimeMidnight()->modify($modify . ' ' . $openingHours->getOpenTime());
        $todayClose = $this->getTimeMidnight()->modify($modify . ' ' . $openingHours->getCloseTime());

        if (($time >= $todayOpen && $time < $todayClose)) {
            $status = new Status\Opened;
        } else {
            $status = new Status\Closed;
        }

        $resolver = new Resolver\WeekDay();
        $resolver->setDay($day->format('w'));
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
            return $this->closingAtByWeekDay($status->getResolver()->getDay());
        }

        return FALSE;
    }

    /**
     * 
     * @return string
     */
    private function closingAtByWeekDay($day) {
        $closing = $this->getTimeMidnight()->modify($this->model->getDay($day)->getCloseTime());
        return $closing->format('H:i');
    }

}
