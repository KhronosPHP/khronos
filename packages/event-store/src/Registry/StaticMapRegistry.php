<?php

namespace Khronos\EventStore\Registry;

use RuntimeException;

final class StaticMapRegistry implements Registry
{
    private array $eventToTypeMappings = [];

    private array $typeToEventMappings = [];

    /**
     * @param array<class-string, string> $mappings
     */
    public function __construct(array $mappings = [])
    {
        $this->typeToEventMappings = $mappings;
        $this->eventToTypeMappings = array_flip($mappings);
    }

    public function eventTypeFor(string $class): string
    {
        return $this->typeToEventMappings[$class] ?? throw new RuntimeException();
    }

    public function classFor(string $eventType): string
    {
        return $this->eventToTypeMappings[$eventType] ?? throw new RuntimeException();
    }
}