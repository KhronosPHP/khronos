<?php

namespace Khronos\Discovery\Tests\Unit\Rule;

use Khronos\Discovery\Rule\Class\HasAttribute;
use Khronos\Discovery\Tests\Unit\Fixtures\TestAttribute;
use Khronos\Discovery\Tests\Unit\Fixtures\TestClassWithAttribute;
use Khronos\Discovery\Tests\Unit\Fixtures\TestClassWithoutAttribute;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class HasAttributeTest extends TestCase
{
    public function test_it_matches_if_class_has_attribute()
    {
        $rule = new HasAttribute(TestAttribute::class);
        $class = new ReflectionClass(TestClassWithAttribute::class);

        $this->assertTrue(
            $rule->matches($class)
        );
    }

    public function test_it_does_not_match_if_class_does_not_have_attribute()
    {
        $rule = new HasAttribute(TestAttribute::class);
        $class = new ReflectionClass(TestClassWithoutAttribute::class);

        $this->assertFalse(
            $rule->matches($class)
        );
    }
}