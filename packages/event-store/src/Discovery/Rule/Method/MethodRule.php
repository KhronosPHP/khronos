<?php

namespace Khronos\EventStore\Discovery\Rule\Method;

use ReflectionMethod;

interface MethodRule
{
    public function matches(ReflectionMethod $reflectionClass): bool;
}