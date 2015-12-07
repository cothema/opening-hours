<?php

namespace Cothema\OpeningHours\Filter\I;

interface Filter {

    public function __construct($input);

    public function getOutput();
}
