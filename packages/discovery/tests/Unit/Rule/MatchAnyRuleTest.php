<?php

namespace Khronos\Discovery\Tests\Unit\Rule;

use Khronos\Discovery\Rule\Class\HasAttribute;
use Khronos\Discovery\Rule\Class\HasMethod;
use Khronos\Discovery\Rule\Class\MatchAny;
use Khronos\Discovery\Tests\Unit\Fixtures\TestAttribute;
use Khronos\Discovery\Tests\Unit\Fixtures\TestClassWithAttribute;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class MatchAnyRuleTest extends TestCase
{
    public function test_it_matches_when_only_one_rule_matches()
    {
        $rule = new MatchAny(
            new HasAttribute(TestAttribute::class),
            new HasMethod('thisMethodDoesNotExist'),
        );

        $class = new ReflectionClass(TestClassWithAttribute::class);

        $this->assertTrue(
            $rule->matches($class)
        );
    }

    public function test_it_does_not_match_when_no_rule_matches()
    {
        $rule = new MatchAny(
            new HasMethod('thisMethodDoesNotExist'),
            new HasMethod('thisMethodAlsoDoesntExist'),
        );

        $class = new ReflectionClass(TestClassWithAttribute::class);

        $this->assertFalse(
            $rule->matches($class)
        );
    }
}