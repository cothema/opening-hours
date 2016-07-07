<?php

namespace Cothema\OpeningHours\T;

use Cothema\OpeningHours\Exception\Tag\TagNotExists;

/**
 * 
 * @author Milos Havlicek <miloshavlicek@gmail.com>
 */
trait Tags {

    /** @var array */
    private $tags = [];

    /**
     * 
     * @param \Cothema\OpeningHours\T\Cothema\OpeningHours\Tag\A\Tag $tag
     */
    public function addTag(Cothema\OpeningHours\Tag\A\Tag $tag) {
        $this->tags[] = $tag;
    }

    /**
     * 
     * @param string $tag
     * @throws TagNotExists
     */
    public function addTagString($tag) {
        $class = 'Cothema\\OpeningHours\\Tag\\' . $tag;
        if (class_exists($class)) {
            $this->tags[] = new $class;
        } else {
            throw new TagNotExists(sprintf('Tag "%s" does not exists!', $tag));
        }
    }

    /**
     * 
     * @return array
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * 
     * @param array $tags
     */
    public function setTags(array $tags) {
        $this->tags = $tags;
    }

}
