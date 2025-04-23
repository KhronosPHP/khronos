<?php

namespace Khronos\Discovery\Rule\Method;

use ReflectionMethod;

interface MethodRule
{
    public function matches(ReflectionMethod $reflectionClass): bool;
}