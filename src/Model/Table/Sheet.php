<?php

namespace Cothema\OpeningHours\Model\Table;

use Nette\SmartObject;

/**
 *
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Sheet
{

    use SmartObject;

    /** @var array */
    private $lines = [];

    /**
     *
     * @param \Cothema\OpeningHours\Model\Table\Line $line
     */
    public function addLine(Line $line): void
    {
        $this->lines[] = $line;
    }

    /**
     *
     * @param boolean $skipClosed Skip lines with closed days
     * @return array
     */
    public function getLines(bool $skipClosed = false): array
    {
        $lines = $this->lines;
        if ($skipClosed) {
            $lines = array_filter($lines, function ($item) {
                return (bool)$item->getTimeFrom();
            });
        }

        return $lines;
    }

}
