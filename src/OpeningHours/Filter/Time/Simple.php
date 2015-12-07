<?php

namespace Cothema\OpeningHours\Filter\Time;

class Simple extends \Nette\Object implements \Cothema\OpeningHours\Filter\I\Filter {

    private $input;
    private $applied;
    private $output;

    public function __construct($input) {
        $this->input = $input;
    }

    private function apply() {
        $this->output = str_replace(':00', '', $this->input);
    }

    public function getOutput() {
        !$this->applied && $this->apply();

        return $this->output;
    }

}
