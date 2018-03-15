<?php

namespace Cothema\OpeningHours\Generator\Table;

use Cothema\OpeningHours\Model\Table;
use Cothema\Time\Filter\Time as FilterTime;
use Nette\Utils\DateTime;

/**
 * Generator for specific days only table (e.g. 1st January 2016: closed)
 *
 * @property int $nextDays
 * @property int $previousDays
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class SpecificDays extends A\Table
{

    /** @var integer */
    private $previousDays = 0;

    /** @var integer */
    private $nextDays = 30;

    /**
     * @return int
     */
    public function getNextDays(): int
    {
        return $this->nextDays;
    }

    /**
     * @param int $nextDays
     */
    public function setNextDays(int $nextDays): void
    {
        $this->nextDays = $nextDays;
    }

    /**
     * @return int
     */
    public function getPreviousDays(): int
    {
        return $this->previousDays;
    }

    /**
     * @param int $previousDays
     */
    public function setPreviousDays(int $previousDays): void
    {
        $this->previousDays = $previousDays;
    }

    /**
     * Generate table
     */
    protected function generate(): void
    {
        $days = $this->getSpecificDays();

        $table = new Table\Sheet;

        $line = new Table\Line;
        $lastTimeFrom = null;
        $lastTimeTo = null;
        $lastDay = null;
        $lastTags = null;
        $now = new DateTime();

        foreach ($days as $day) {
            $timeFrom = (new FilterTime\Def($day->openTime))->output;
            $timeTo = (new FilterTime\Def($day->closeTime))->output;

            if ($lastTimeFrom === $timeFrom && $lastTimeTo === $timeTo && $this->tagsAreSame($lastTags, $day->tags) && $lastDay !== null && (int)$lastDay->day->diff($day->day)->format('%r%a') === 1) {
                $line->dateTo = $day->day;
            } else {
                ($lastTimeTo !== null) && $table->addLine($line);
                $line = new Table\Line;
                $line->dateFrom = $day->day;
                $line->dateTo = $day->day;
                $line->tags = $day->tags;
                $this->lineAddTime($line, $timeFrom, $timeTo);
            }

            if ($day->day->format('Y-m-d') === $now->format('Y-m-d')) {
                $line->setActive();
            }

            $lastTags = $day->tags;
            $lastTimeFrom = $timeFrom;
            $lastTimeTo = $timeTo;
            $lastDay = $day;
        }

        ($lastTimeTo !== null) && $table->addLine($line);

        $this->generatedTable = $table;
    }

    private function getSpecificDays()
    {
        return $this->openingHours->getSpecificDays($this->nextDays, $this->previousDays);
    }

    /**
     *
     * @param array $tagsA
     * @param array $tagsB
     * @return boolean;
     */
    private function tagsAreSame(array $tagsA, array $tagsB)
    {
        if ($tagsA === $tagsB) {
            return true;
        }

        if (count($tagsA) !== count($tagsB)) {
            return false;
        }

        for ($i = 0; $i < count($tagsA); $i++) {
            if (!(string)$tagsA[$i] === (string)$tagsB[$i]) {
                return false;
            }
        }

        return true;
    }

    private function lineAddTime($line, $timeFrom, $timeTo)
    {
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

}
