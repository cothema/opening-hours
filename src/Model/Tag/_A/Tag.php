<?php

namespace Cothema\OpeningHours\Model\Tag\A;

use Nette\SmartObject;

/**
 *
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
abstract class Tag
{

    use SmartObject;

    public function __toString()
    {
        $class = $this->reflection->name;
        $exploded = explode('\\', $class);
        return $exploded[count($exploded) - 1];
    }

}
