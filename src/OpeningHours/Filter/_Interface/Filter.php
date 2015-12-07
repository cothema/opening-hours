<?php

namespace Cothema\OpeningHours\Filter\I\Filter;

interface Filter {

    public function __construct($input);

    public function getOutput();
}
