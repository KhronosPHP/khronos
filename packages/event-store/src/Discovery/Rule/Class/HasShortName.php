<?php

namespace Khronos\EventStore\Discovery\Rule\Class;

use ReflectionClass;

final class HasShortName implements ClassRule
{
    public function __construct(
        private string $shortName,
    ) {}

    public function matches(ReflectionClass $reflectionClass): bool
    {
        return $reflectionClass->getShortName() === $this->shortName;
    }
}
