<?php

namespace Khronos\EventStore\Tests\Unit\EventStore\Registry;

use Khronos\EventStore\Registry\FqcnRegistry;
use Khronos\EventStore\Tests\Unit\Fixtures\BookWasCheckedOut;
use PHPUnit\Framework\TestCase;

final class FqcnRegistryTest extends TestCase
{
    public function test_getting_type_for_event(): void
    {
        $registry = new FqcnRegistry();

        $event = $registry->classFor(BookWasCheckedOut::class);

        $this->assertSame(BookWasCheckedOut::class, $event);
    }

    public function test_getting_event_for_type(): void
    {
        $registry = new FqcnRegistry();

        $event = $registry->eventTypeFor(BookWasCheckedOut::class);

        $this->assertSame(BookWasCheckedOut::class, $event);
    }
}
