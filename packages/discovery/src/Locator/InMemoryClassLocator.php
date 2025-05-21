<?php

namespace Khronos\Discovery;

use ArrayIterator;
use Traversable;

final class InMemoryClassLocator implements ClassLocator
{
    public function __construct(private array $classes)
    {}

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->classes);
    }
}