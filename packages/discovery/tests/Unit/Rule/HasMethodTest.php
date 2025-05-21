<?php

namespace Khronos\Discovery\Tests\Unit\Rule;

use Khronos\Discovery\Rule\Class\HasMethod;
use Khronos\Discovery\Tests\Unit\Fixtures\TestClassWithAttribute;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class HasMethodTest extends TestCase
{
    public function test_it_matches_if_class_has_method()
    {
        $rule = new HasMethod('thisIsATestMethod');
        $class = new ReflectionClass(TestClassWithAttribute::class);

        $this->assertTrue(
            $rule->matches($class)
        );
    }

    public function test_it_does_not_match_if_class_does_not_have_method()
    {
        $rule = new HasMethod('thisMethodDoesNotExist');
        $class = new ReflectionClass(TestClassWithAttribute::class);

        $this->assertFalse(
            $rule->matches($class)
        );
    }
}