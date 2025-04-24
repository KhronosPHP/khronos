<?php

namespace Khronos\EventSourcing;

use ReflectionClass;
use ReflectionUnionType;

final class ParameterTypeEventApplier implements EventApplier
{
    public function apply(object $aggregate, object $event): void
    {
        $reflectionClass = new ReflectionClass($aggregate);
        $reflectionMethods = $reflectionClass->getMethods();

        foreach ($reflectionMethods as $reflectionMethod) {
            $firstParameter = $reflectionMethod->getParameters()[0] ?? null;

            if (! $firstParameter) {
                continue;
            }

            $types = ($firstParameter instanceof ReflectionUnionType)
                ? $firstParameter->getTypes()
                : [$firstParameter->getType()];

            foreach ($types as $type) {
                if ($type->getName() === $event::class) {
                    $reflectionMethod->invoke($aggregate, $event);

                    // Short circuit, people shouldn't have multiple
                    // handler methods.
                    return;
                }
            }
        }
    }
}
