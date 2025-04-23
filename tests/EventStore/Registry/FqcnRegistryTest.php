<?php

namespace Khronos\Tests\EventStore\Registry;

use Khronos\EventStore\Registry\FqcnRegistry;
use Khronos\Tests\Fixtures\BookWasCheckedOut;
use PHPUnit\Framework\TestCase;

final class FqcnRegistryTest extends TestCase
{
    public function test_getting_type_for_event()
    {
        $registry = new FqcnRegistry();

        $event = $registry->classFor(BookWasCheckedOut::class);

        $this->assertSame(BookWasCheckedOut::class, $event);
    }

    public function test_getting_event_for_type()
    {
        $registry = new FqcnRegistry();

        $event = $registry->eventTypeFor(BookWasCheckedOut::class);

        $this->assertSame(BookWasCheckedOut::class, $event);
    }
}