<?php

namespace Cothema\OpeningHours\Generator\Table;

use Cothema\OpeningHours\Model\WeekTable;
use Cothema\Time\Filter\Time as FilterTime;
use Cothema\Time\Validator;

/**
 * Generator for week days table (e.g. mon-fri: 8 AM - 6 PM, sat, sun: closed) 
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class WeekDays extends A\Table {

    /** @var int */
    private $firstDayInWeek = 1;

    /**
     * Generate table
     */
    protected function generate() {
        $openingHours = $this->openingHours;

        $days = [0, 1, 2, 3, 4, 5, 6, 0, 1, 2, 3, 4, 5];
        $walked = [];

        $weekTable = new WeekTable\Table;

        $line = new WeekTable\Line;
        $lastTimeFrom = NULL;
        $lastTimeTo = NULL;
        $started = FALSE;
        foreach ($days as $day) {
            if (!$started && $day !== $this->firstDayInWeek) {
                continue;
            }
            $started = TRUE;
            if (in_array($day, $walked)) {
                break;
            }
            $walked[] = $day;

            $dayOpeningHours = $openingHours->getWeekDay($day);

            $timeFrom = (new FilterTime\Def($dayOpeningHours->getOpenTime()))->getOutput();
            $timeTo = (new FilterTime\Def($dayOpeningHours->getCloseTime()))->getOutput();
            foreach ($this->timeFilters as $filter) {
                $timeFromFormatted = (new $filter($timeFrom))->getOutput();
                $timeToFormatted = (new $filter($timeTo))->getOutput();
            }
            if ($timeFrom === $lastTimeFrom && $timeTo === $lastTimeTo) {
                $line->setDayTo($day);
            } else {
                ($lastTimeTo !== NULL) && $weekTable->addLine($line);
                $line = new WeekTable\Line;
                $line->setDayFrom($day);
                $line->setDayTo($day);
                $line->setTimeFrom($timeFrom);
                $line->setTimeFromFormatted($timeFromFormatted);
                $line->setTimeTo($timeTo);
                $line->setTimeToFormatted($timeToFormatted);
            }

            if ((string) $day === (string) date('w')) {
                $line->setActive();
            }

            $lastTimeFrom = $timeFrom;
            $lastTimeTo = $timeTo;
        }

        ($lastTimeTo !== NULL) && $weekTable->addLine($line);

        $this->generatedTable = $weekTable;
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
