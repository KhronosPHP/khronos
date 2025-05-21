<?php

namespace Khronos\EventSourcing\Tests\Unit\Stream;

use Khronos\EventSourcing\Stream\AttributeStreamNameResolver;
use Khronos\EventSourcing\Stream\FqcnStreamNameResolver;
use Khronos\EventSourcing\Tests\Unit\Fixtures\Book;
use PHPUnit\Framework\TestCase;

class AttributeStreamNameResolverTest extends TestCase
{
    public function test_it_can_resolve_a_stream_name()
    {
        $resolver = new AttributeStreamNameResolver();

        $this->assertSame(
            'book',
            $resolver->resolve(new Book()),
        );
    }
}
