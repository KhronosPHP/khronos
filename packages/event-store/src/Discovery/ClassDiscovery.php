<?php

namespace Khronos\EventStore\Discovery;

use Generator;
use Khronos\EventStore\Discovery\Locator\ClassLocator;
use Khronos\EventStore\Discovery\Rule\Class\ClassRule;
use ReflectionClass;

final class ClassDiscovery
{
    private array $rules = [];

    public function __construct(private ClassLocator $classLocator)
    {}

    public function withRule(ClassRule $rule): self
    {
        $clone = clone $this;

        $clone->rules[] = $rule;

        return $clone;
    }

    /**
     * @return Generator<ReflectionClass>
     */
    public function discover(): Generator
    {
        foreach ($this->classLocator as $class) {
            $reflectionClass = new ReflectionClass($class);

            foreach ($this->rules as $rule) {
                if (! $rule->matches($reflectionClass)) {
                    continue 2;
                }
            }

            yield $reflectionClass;
        }
    }
}