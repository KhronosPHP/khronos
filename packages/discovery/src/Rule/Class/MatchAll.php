<?php

namespace Khronos\Discovery\Rule\Class;

use ReflectionClass;

final class MatchAll implements ClassRule
{
    private array $rules;

    public function __construct(ClassRule ...$rules)
    {
        $this->rules = $rules;
    }

    public function matches(ReflectionClass $class): bool
    {
        foreach ($this->rules as $rule) {
            if (! $rule->matches($class)) {
                return false;
            }
        }

        return true;
    }
}