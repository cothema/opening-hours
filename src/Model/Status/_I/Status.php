<?php

namespace Cothema\OpeningHours\Model\Status\I;

/**
 *
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
interface Status
{

    public function getResolver();

    public function setResolver($resolver);
}
