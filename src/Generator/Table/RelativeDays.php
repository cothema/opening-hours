<?php

namespace Cothema\OpeningHours\Generator\Table;

use Cothema\OpeningHours\Model\Table;
use Cothema\Time\Filter\Time as FilterTime;
use Nette\Utils\DateTime;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class RelativeDays extends A\Table {

    /** @var integer */
    private $previousDays = 0;

    /** @var integer */
    private $nextDays = 2;

    protected function generate() {
        $openingHours = $this->openingHours;

        $days = $this->getRelativeDays();

        $table = new Table\Sheet;

        foreach ($days as $day) {
            $line = new Table\Line;
            if ($day === 0) {
                $line->setActive();
            }

            $now = new DateTime();
            $dayOpeningHours = $openingHours->getDay($day === 0 ? $now : $now->modifyClone(($day > 0 ? '+' : '-') . $day . ' days'));
            $timeFrom = (new FilterTime\Def($dayOpeningHours->getOpenTime()))->getOutput();
            $timeTo = (new FilterTime\Def($dayOpeningHours->getCloseTime()))->getOutput();
            foreach ($this->timeFilters as $filter) {
                $timeFromFormatted = (new $filter($timeFrom))->getOutput();
                $timeToFormatted = (new $filter($timeTo))->getOutput();
            }

            $line->setTitle($day);
            $line->setTimeFrom($timeFrom);
            $line->setTimeFromFormatted($timeFromFormatted);
            $line->setTimeTo($timeTo);
            $line->setTimeToFormatted($timeToFormatted);
            $table->addLine($line);
        }

        $this->generatedTable = $table;
    }

    private function getRelativeDays() {
        $days = [];
        for ($i = $this->previousDays; $i < 0; $i++) {
            $days[] = $i;
        }

        $days[] = 0;

        for ($i = 1; $i <= $this->nextDays; $i++) {
            $days[] = $i;
        }
        return $days;
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
