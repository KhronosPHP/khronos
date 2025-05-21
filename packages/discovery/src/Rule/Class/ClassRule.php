<?php

namespace Khronos\Discovery\Rule\Class;

use ReflectionClass;

interface ClassRule
{
    public function matches(ReflectionClass $class): bool;
}