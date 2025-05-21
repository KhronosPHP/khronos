<?php

namespace Khronos\Discovery\Tests\Unit\Rule;

use Khronos\Discovery\Rule\Class\HasAttribute;
use Khronos\Discovery\Rule\Class\HasMethod;
use Khronos\Discovery\Rule\Class\MatchAll;
use Khronos\Discovery\Tests\Unit\Fixtures\TestAttribute;
use Khronos\Discovery\Tests\Unit\Fixtures\TestClassWithAttribute;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class MatchAllRuleTest extends TestCase
{
    public function test_it_matches_if_all_rules_match()
    {
        $rule = new MatchAll(
            new HasAttribute(TestAttribute::class),
            new HasMethod('thisIsATestMethod'),
        );

        $class = new ReflectionClass(TestClassWithAttribute::class);

        $this->assertTrue(
            $rule->matches($class)
        );
    }

    public function test_it_does_not_match_if_one_rule_does_not_match()
    {
        $rule = new MatchAll(
            new HasAttribute(TestAttribute::class),
            new HasMethod('thisMethodDoesNotExist'),
        );

        $class = new ReflectionClass(TestClassWithAttribute::class);

        $this->assertFalse(
            $rule->matches($class)
        );
    }
}