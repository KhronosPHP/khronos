<?php

namespace Khronos\Discovery;

use Traversable;

final class ComposerClassMapClassLocator implements ClassLocator
{
    public function __construct(
        private string $autoloadClassmapPath,
    ) {}

    public function getIterator(): Traversable
    {
        $classMap = require $this->autoloadClassmapPath;

        foreach ($classMap as $class => $file) {
            if (class_exists($class)) {
                yield $class;
            }
        }
    }
}