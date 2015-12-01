<?php

namespace App\Components\OpeningHours;

use \Nette\DateTime;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Status extends \Nette\Object {

    /** @var \App\Components\OpeningHours\Model */
    private $model;

    /** @var \Nette\DateTime */
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
     * @return \Nette\DateTime
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
     * @param \Nette\DateTime $time
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
        $opened = $this->model->getDay($this->time->format('w'));

        $todayOpen = new DateTime($opened->getOpenTime());
        $todayClose = new DateTime($opened->getCloseTime());

        return ($this->time >= $todayOpen && $this->time < $todayClose);
    }

    /**
     * 
     * @return string|boolean
     */
    public function getClosingAtWarning() {
        if ($this->isOpened() && !$this->isOpened($this->time->diff('+2 hours'))) {
            return $this->closingAt();
        }

        return FALSE;
    }

    /**
     * 
     * @return 
     */
    private function closingAt() {
        $closing = new DateTime($this->model->getDay($time->format('w'))->getCloseTime);
        return $closing->format('H:i');
    }

}
