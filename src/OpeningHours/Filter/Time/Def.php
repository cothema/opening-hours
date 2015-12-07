<?php

namespace Cothema\OpeningHours\Filter\Time;

class Def extends \Cothema\OpeningHours\Filter\A\Filter implements \Cothema\OpeningHours\Filter\I\Filter {

    protected function apply() {
        $this->output = (new DateTime($this->input))->format('h:i');
    }

}
