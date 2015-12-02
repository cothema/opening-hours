<?php

namespace Cothema\OpeningHours;

use \Nette\Utils\DateTime;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Status extends \Nette\Object {

    /** @var \App\Components\OpeningHours\Model */
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
        $openingHours = $this->model->getDay($time->format('w'));

        $todayOpen = $this->getTimeMidnight()->modify($openingHours->getOpenTime());
        $todayClose = $this->getTimeMidnight()->modify($openingHours->getCloseTime());

        return ($time >= $todayOpen && $time < $todayClose);
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
        if ($this->isOpened() && !$this->isOpenedByTime($time->modify('+2 hours'))) {
            return $this->closingAt();
        }

        return FALSE;
    }

    /**
     * 
     * @return string
     */
    private function closingAt() {
        $closing = $this->getTimeMidnight()->modify($this->model->getDay($this->time->format('w'))->getCloseTime());
        return $closing->format('H:i');
    }

}
