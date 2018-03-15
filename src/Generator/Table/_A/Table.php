<?php

namespace Cothema\OpeningHours\Generator\Table\A;

use Cothema\OpeningHours\Exception\Generator\FilterClassNotExists;
use Cothema\OpeningHours\Exception\MissingImplementation;
use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Model\Table\Sheet;
use Cothema\OpeningHours\Model\WeekTable;
use Nette\SmartObject;

/**
 * @property-read object $table
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
abstract class Table implements \Cothema\OpeningHours\Generator\Table\I\Table
{

    use SmartObject;

    /** @var Sheet */
    protected $generatedTable;

    /** @var OpeningHours */
    protected $openingHours;

    /** @var array */
    protected $timeFilters = [];

    /**
     *
     * @param OpeningHours $openingHours
     */
    public function __construct(OpeningHours $openingHours)
    {
        $this->openingHours = $openingHours;
        $this->addTimeFilter('Time\\Def');
    }

    /**
     *
     * @param string $filter e.g. Time\Simple
     * @throws FilterClassNotExists
     */
    public function addTimeFilter(string $filter): void
    {
        $filterClass = '\\Cothema\\Time\\Filter\\' . $filter;

        if (!class_exists($filterClass)) {
            throw new FilterClassNotExists('Filter class "' . $filterClass . '" does not exists.');
        }

        $this->timeFilters[] = $filterClass;
    }

    /**
     *
     * @return Sheet
     */
    public function getTable(): Sheet
    {
        $this->generate();
        return $this->generatedTable;
    }

    /**
     * Generate concrete table (concrete implementation required).
     *
     * @throws MissingImplementation
     */
    protected function generate()
    {
        throw new MissingImplementation();
    }

}
