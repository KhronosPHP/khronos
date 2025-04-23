<?php

namespace Khronos\EventStore\Discovery\Locator;

use Traversable;

final class ComposerClassMapClassLocator implements ClassLocator
{
    public function __construct(
        private readonly string $autoloadClassmapPath,
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