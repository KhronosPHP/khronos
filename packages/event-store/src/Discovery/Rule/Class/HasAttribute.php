<?php

namespace Khronos\EventStore\Discovery\Rule\Class;

use ReflectionClass;

final class HasAttribute implements ClassRule
{
    public function __construct(
        private string $attribute,
    ) {}

    public function matches(ReflectionClass $reflectionClass): bool
    {
        return count($reflectionClass->getAttributes($this->attribute)) !== 0;
    }
}
