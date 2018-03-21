<?php

namespace Cothema\OpeningHours\Model\Status\A;

use Nette\SmartObject;

/**
 *
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
abstract class Status implements \Cothema\OpeningHours\Model\Status\I\Status
{

    use SmartObject;
    use \Cothema\OpeningHours\Model\T\Tags;

    private $resolver;

    public function getResolver()
    {
        return $this->resolver;
    }

    public function setResolver($resolver)
    {
        $this->resolver = $resolver;
    }

}
