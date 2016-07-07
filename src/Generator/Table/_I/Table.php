<?php

namespace Cothema\OpeningHours\Generator\Table\I;

use Cothema\OpeningHours\Model\OpeningHours;
use Cothema\OpeningHours\Exception\Generator\FilterClassNotExists;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
interface Table {

    /**
     * 
     * @param OpeningHours $openingHours
     */
    public function __construct(OpeningHours $openingHours);

    /**
     * 
     * @param string $filter e.g. Time\Simple
     * @throws FilterClassNotExists
     */
    public function addTimeFilter($filter);

    /**
     * 
     * @return array
     */
    public function getTable();

}
