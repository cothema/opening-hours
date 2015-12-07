<?php

namespace Cothema\OpeningHours\Filter\Time;

class Simple extends \Cothema\OpeningHours\Filter\A\Filter implements \Cothema\OpeningHours\Filter\I\Filter {

    protected function apply() {
        $this->output = str_replace(':00', '', $this->input);
    }

}
