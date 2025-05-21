<?php

namespace Khronos\Discovery;

use Khronos\Discovery\Rule\MethodRule;
use ReflectionMethod;

interface MethodDiscoveryAgent
{
    public function getMatchingRule(): MethodRule;

    public function onMatch(ReflectionMethod $method): void;
}