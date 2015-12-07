<?php

namespace Cothema\OpeningHours\Filter\A;

abstract class Filter extends \Nette\Object {

    protected $input;
    protected $applied;
    protected $output;

    public function __construct($input) {
        $this->input = $input;
    }

    public function __toString() {
        return $this->getOutput();
    }

    protected function apply() {
        $this->output = $this->input;
    }

    public function getOutput() {
        !$this->applied && $this->apply();

        return $this->output;
    }

}
