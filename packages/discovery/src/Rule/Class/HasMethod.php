<?php

namespace Khronos\Discovery\Rule\Class;

use ReflectionClass;

final class HasMethod implements ClassRule
{
    public function __construct(private string $method)
    {}

    public function matches(ReflectionClass $class): bool
    {
        return $class->hasMethod($this->method);
    }
}