<?php

namespace Cothema\OpeningHours\Generator;

use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Model\WeekTable;
use Cothema\OpeningHours\Validator;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Table extends \Nette\Object {

    /** @var OpeningHours */
    private $openingHours;

    /** @var WeekTable\Table */
    private $generatedTable;

    /** @var int */
    private $firstDayInWeek = 1;

    /** @var array */
    private $timeFilters = [];
    
    /**
     * 
     * @param OpeningHours $openingHours
     */
    public function __construct(OpeningHours $openingHours) {
        $this->openingHours = $openingHours;
    }
    
    /**
     * 
     * @param string $filter e.g. Time\Simple
     * @throws \Exception
     */
    public function addTimeFilter($filter) {
        $filterClass = '\\Cothema\\OpeningHours\\Filter\\'.$filter;
        
        if(!class_exists($filterClass)) {
            throw new \Exception('Filter class "'.$filterClass.'" does not exists.');
        }
        
        $this->timeFilters[] = $filterClass;
    }

    private function generate() {
        $openingHours = $this->openingHours;

        $days = [0, 1, 2, 3, 4, 5, 6, 0, 1, 2, 3, 4, 5];
        $walked = [];

        $weekTable = new WeekTable\Table;

        $line = new WeekTable\Line;
        $lastTimeFrom = NULL;
        $lastTimeTo = NULL;
        $started = FALSE;
        foreach ($days as $day) {
            if(!$started && $day !== $this->firstDayInWeek) {
                continue;
            }
            $started = TRUE;
            if (in_array($day, $walked)) {
                break;
            }
            $walked[] = $day;

            $dayOpeningHours = $openingHours->getWeekDay($day);

            $timeFrom = $dayOpeningHours->getOpenTime();
            $timeTo = $dayOpeningHours->getCloseTime();
            foreach($this->timeFilters as $filter) {
                $timeFrom = (new $filter($timeFrom))->getOutput();
                $timeTo = (new $filter($timeTo))->getOutput();
            }
            if ($timeFrom === $lastTimeFrom && $timeTo === $lastTimeTo) {
                $line->setDayTo($day);
            } else {
                isset($lastTimeTo) && $weekTable->addLine($line);
                $line = new WeekTable\Line;
                $line->setDayFrom($day);
                $line->setDayTo($day);
                $line->setTimeFrom($timeFrom);
                $line->setTimeTo($timeTo);
            }

            $lastTimeFrom = $timeFrom;
            $lastTimeTo = $timeTo;
        }

        isset($lastTimeTo) && $weekTable->addLine($line);

        $this->generatedTable = $weekTable;
    }

    /**
     * 
     * @return array
     */
    public function getTable() {
        $this->generate();
        return $this->generatedTable;
    }

    /**
     * 
     * @return int
     */
    public function getFirstDayInWeek() {
        return $this->firstDayInWeek;
    }

    /**
     * 
     * @param int $dayNum
     */
    public function setFirstDayInWeek($dayNum) {
        Validator\WeekDayNumber::validate($dayNum);
        $this->firstDayInWeek = $dayNum;
    }

}
