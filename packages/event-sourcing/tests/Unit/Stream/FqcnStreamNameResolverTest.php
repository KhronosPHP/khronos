<?php

namespace Khronos\EventSourcing\Tests\Unit\Stream;

use Khronos\EventSourcing\Stream\FqcnStreamNameResolver;
use Khronos\EventSourcing\Tests\Unit\Fixtures\Book;
use PHPUnit\Framework\TestCase;

class FqcnStreamNameResolverTest extends TestCase
{
    public function test_it_can_resolve_a_stream_name()
    {
        $resolver = new FqcnStreamNameResolver();

        $this->assertSame(
            Book::class,
            $resolver->resolve(new Book()),
        );
    }
}
