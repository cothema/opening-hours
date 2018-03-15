<?php

namespace Cothema\OpeningHours\Generator\Table;

use Cothema\OpeningHours\Model\Table;
use Cothema\Time\Filter\Time as FilterTime;
use Nette\Utils\DateTime;

/**
 * Generator for relative days table (e.g. today: closed, tommorow: 9 AM - 2 PM) 
 *
 * @property int $nextDays
 * @property int $previousDays
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class RelativeDays extends A\Table {

    /** @var integer */
    private $previousDays = 0;

    /** @var integer */
    private $nextDays = 2;

    /**
     * Generate table
     */
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
            $line->tags = $dayOpeningHours->tags;
            if ($dayOpeningHours instanceof \Cothema\OpeningHours\Model\SpecificDay) {
                $line->specific = true;
            }
            $table->addLine($line);
        }

        $this->generatedTable = $table;
    }

    /**
     * @return array
     */
    private function getRelativeDays(): array {
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

    /**
     * @return int
     */
    public function getNextDays(): int {
        return $this->nextDays;
    }

    /**
     * @return int
     */
    public function getPreviousDays(): int {
        return $this->previousDays;
    }

    /**
     * @param int $nextDays
     */
    public function setNextDays(int $nextDays) {
        $this->nextDays = $nextDays;
    }

    /**
     * @param int $previousDays
     */
    public function setPreviousDays(int $previousDays) {
        $this->previousDays = $previousDays;
    }

}
