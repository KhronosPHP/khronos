<?php

namespace Khronos\Discovery;

use IteratorAggregate;
use Traversable;

interface ClassLocator extends IteratorAggregate
{
    /**
     * @return Traversable<class-string>
     */
    public function getIterator(): Traversable;
}