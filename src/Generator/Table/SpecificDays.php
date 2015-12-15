<?php

namespace Cothema\OpeningHours\Generator\Table;

use Cothema\OpeningHours\Model\Table;
use Cothema\Time\Filter\Time as FilterTime;
use Nette\Utils\DateTime;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class SpecificDays extends A\Table {

    /** @var integer */
    private $previousDays = 0;

    /** @var integer */
    private $nextDays = 30;

    protected function generate() {
        $openingHours = $this->openingHours;

        $days = $this->getSpecificDays();

        $table = new Table\Sheet;

        $line = new Table\Line;
        $lastTimeFrom = NULL;
        $lastTimeTo = NULL;
        $now = new DateTime();

        foreach ($days as $day) {
            $timeFrom = (new FilterTime\Def($day->getOpenTime()))->getOutput();
            $timeTo = (new FilterTime\Def($day->getCloseTime()))->getOutput();

            if ($lastTimeFrom === $timeFrom && $lastTimeTo === $timeTo) {
                $line->dateTo = $day->getDay();
            } else {
                ($lastTimeTo !== NULL) && $table->addLine($line);
                $line = new Table\Line;
                $line->dateFrom = $day->getDay();
                $line->dateTo = $day->getDay();
                $this->lineAddTime($line, $timeFrom, $timeTo);
            }

            if ($day->getDay()->format('Y-m-d') === $now->format('Y-m-d')) {
                $line->setActive();
            }

            $lastTimeFrom = $timeFrom;
            $lastTimeTo = $timeTo;
        }

        ($lastTimeTo !== NULL) && $table->addLine($line);

        $this->generatedTable = $table;
    }

    private function lineAddTime($line, $timeFrom, $timeTo) {
        foreach ($this->timeFilters as $filter) {
            $timeFromFormatted = (new $filter($timeFrom))->getOutput();
            $timeToFormatted = (new $filter($timeTo))->getOutput();
        }

        $line->setTimeFrom($timeFrom);
        $line->setTimeFromFormatted($timeFromFormatted);
        $line->setTimeTo($timeTo);
        $line->setTimeToFormatted($timeToFormatted);
        return $line;
    }

    private function getSpecificDays() {
        return $this->openingHours->getSpecificDays($this->nextDays, $this->previousDays);
    }

    public function getNextDays() {
        return $this->nextDays;
    }

    public function getPreviousDays() {
        return $this->previousDays;
    }

    public function setNextDays($nextDays) {
        $this->nextDays = $nextDays;
    }

    public function setPreviousDays($previousDays) {
        $this->previousDays = $previousDays;
    }

}
