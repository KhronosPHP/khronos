<?php

namespace Khronos\EventStore\Discovery\Rule\Class;

use ReflectionClass;

interface ClassRule
{
    public function matches(ReflectionClass $reflectionClass): bool;
}