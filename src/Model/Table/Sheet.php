<?php

namespace Cothema\OpeningHours\Model\Table;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Sheet extends \Nette\Object {

    /** @var array */
    private $lines = [];

    /**
     * 
     * @param \Cothema\OpeningHours\Model\Table\Line $line
     */
    public function addLine(Line $line) {
        $this->lines[] = $line;
    }

    /**
     * 
     * @param boolean $skipClosed Skip lines with closed days
     * @return array
     */
    public function getLines($skipClosed = FALSE) {
        $lines = $this->lines;
        if ($skipClosed) {
            $lines = array_filter($lines, function($item) {
                return (bool) $item->getTimeFrom();
            });
        }

        return $lines;
    }

}
