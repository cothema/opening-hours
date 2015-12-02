<?php

namespace Cothema\OpeningHours\Model\I;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
interface Day {

    public function getCloseTime();

    public function getOpenTime();

    public function setCloseTime($closeTime);

    public function setOpenTime($openTime);

}
