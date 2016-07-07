<?php

namespace Cothema\OpeningHours\Generator\Table\A;

use Cothema\OpeningHours\Exception\Generator\FilterClassNotExists;
use Cothema\OpeningHours\Exception\MissingImplementation;
use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Model\WeekTable;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
abstract class Table extends \Nette\Object implements \Cothema\OpeningHours\Generator\Table\I\Table {

    /** @var WeekTable\Table */
    protected $generatedTable;

    /** @var OpeningHours */
    protected $openingHours;

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

    /**
     * 
     * @return WeekTable\Table
     */
    public function getTable() {
        $this->generate();
        return $this->generatedTable;
    }

    /**
     * Generate concrete table (concrete implementation required).
     * 
     * @throws MissingImplementation
     */
    protected function generate() {
        throw new MissingImplementation();
    }

}
