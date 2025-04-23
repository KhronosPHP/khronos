<?php

namespace Khronos\EventSourcing;

use ReflectionClass;

final class MethodNameEventApplier implements EventApplier
{
    public function apply(object $aggregate, object $event): void
    {
        $eventReflectionClass = new ReflectionClass($event);
        $methodName = 'apply' . $eventReflectionClass->getShortName();

        if (! method_exists($aggregate, $methodName)) {
            $aggregate->$methodName($event);
        }
    }
}