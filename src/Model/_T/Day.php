<?php

namespace Cothema\OpeningHours\Model\T;

/**
 * @property int $openTime
 * @property int $closeTime
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
trait Day
{

    /** @var string */
    private $closeTime = false;

    /** @var string */
    private $openTime = false;

    /**
     *
     * @return string
     */
    public function getCloseTime()
    {
        return $this->closeTime;
    }

    /**
     *
     * @param string $closeTime e.g. 22:00
     */
    public function setCloseTime($closeTime)
    {
        $this->closeTime = $closeTime;
    }

    /**
     *
     * @return string
     */
    public function getOpenTime()
    {
        return $this->openTime;
    }

    /**
     *
     * @param string $openTime e.g. 8:00
     */
    public function setOpenTime($openTime)
    {
        $this->openTime = $openTime;
    }

}
