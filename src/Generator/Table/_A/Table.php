<?php

namespace Cothema\OpeningHours\Generator\Table\A;

use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Model\WeekTable;
use Cothema\OpeningHours\Exception\Generator\FilterClassNotExists;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
abstract class Table extends \Nette\Object implements \Cothema\OpeningHours\Generator\Table\I\Table {

    /** @var OpeningHours */
    protected $openingHours;

    /** @var WeekTable\Table */
    protected $generatedTable;

    /** @var array */
    protected $timeFilters = [];

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
     * @throws FilterClassNotExists
     */
    public function addTimeFilter($filter) {
        $filterClass = '\\Cothema\\Time\\Filter\\' . $filter;

        if (!class_exists($filterClass)) {
            throw new FilterClassNotExists('Filter class "' . $filterClass . '" does not exists.');
        }

        $this->timeFilters[] = $filterClass;
    }

    protected function generate() {
        
    }

    public function getTable() {
        $this->generate();
        return $this->generatedTable;
    }

}
