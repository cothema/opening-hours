<?php

namespace Cothema\OpeningHours\Filter\Time;

class Simple extends \Cothema\OpeningHours\Filter\A\Filter implements \Cothema\OpeningHours\Filter\I\Filter {

    protected function apply() {
        if(is_bool($this->input)) {
            $this->output = $this->input;
            return;
        }
        $this->output = str_replace(':00', '', $this->input);
    }

}
