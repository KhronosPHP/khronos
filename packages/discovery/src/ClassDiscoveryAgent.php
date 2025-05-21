<?php

namespace Khronos\Discovery;

use Khronos\Discovery\Rule\Class\ClassRule;
use ReflectionClass;

interface ClassDiscoveryAgent
{
    public function getMatchingRule(): ClassRule;

    public function onMatch(ReflectionClass $class): void;
}