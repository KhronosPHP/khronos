<?php

namespace Khronos\Discovery;

use Khronos\Discovery\Rule\Class\HasAttribute;
use Khronos\EventStore\Registry\Registry;

final class AttributeRegistry implements Registry
{
    private array $map = [];

    public function __construct(ClassDiscovery $discovery)
    {
        $classes = $discovery
            ->withRule(new HasAttribute(Event::class))
            ->discover();

        foreach ($classes as $class) {
            $attribute = $class->getAttributes(Event::class)[0]->newInstance();

            $this->map[$class->getName()] = strval($attribute);
        }
    }

    public function classFor(string $eventType): string
    {
        // TODO(aidan-casey): Clean this up, it's not performant.
        return array_flip($this->map)[$eventType] ?? throw new \RuntimeException();
    }

    public function eventTypeFor(string $class): string
    {
        return $this->map[$class] ?? throw new \RuntimeException();
    }
}