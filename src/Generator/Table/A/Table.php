<?php

namespace Cothema\OpeningHours\Generator\Table\A;

use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Model\WeekTable;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
class Table extends \Nette\Object implements \Cothema\OpeningHours\Generator\Table\I\Table {

    /** @var OpeningHours */
    private $openingHours;

    /** @var WeekTable\Table */
    private $generatedTable;

    /** @var array */
    private $timeFilters = [];

    /**
     * 
     * @param OpeningHours $openingHours
     */
    public function __construct(OpeningHours $openingHours) {
        $this->openingHours = $openingHours;
        $this->addTimeFilter('Time\\Def');
    }

    /**
     * 
     * @param string $filter e.g. Time\Simple
     * @throws \Exception
     */
    public function addTimeFilter($filter) {
        $filterClass = '\\Cothema\\Time\\Filter\\' . $filter;

        if (!class_exists($filterClass)) {
            throw new \Exception('Filter class "' . $filterClass . '" does not exists.');
        }

        $this->timeFilters[] = $filterClass;
    }

    protected function generate() {
        
    }

    /**
     * 
     * @return array
     */
    public function getTable() {
        $this->generate();
        return $this->generatedTable;
    }

}
