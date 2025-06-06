<?php

namespace Khronos\EventStore\Tests\Unit\EventStore\Registry;

use Khronos\EventStore\Registry\StaticMapRegistry;
use Khronos\EventStore\Tests\Unit\Fixtures\BookWasCheckedOut;
use Khronos\EventStore\Tests\Unit\Fixtures\BookWasReturned;
use PHPUnit\Framework\TestCase;

final class InMemoryEventRegistryTest extends TestCase
{
    private StaticMapRegistry $eventRegistry;

    protected function setUp(): void
    {
        $this->eventRegistry = new StaticMapRegistry([
            BookWasCheckedOut::class => 'book.checked-out',
            BookWasReturned::class => 'book.returned',
        ]);
    }

    public function test_getting_event_name_from_type(): void
    {
        $this->assertSame('book.checked-out', $this->eventRegistry->eventTypeFor(BookWasCheckedOut::class));
        $this->assertSame('book.returned', $this->eventRegistry->eventTypeFor(BookWasReturned::class));
    }

    public function test_getting_event_type_from_name(): void
    {
        $this->assertSame(BookWasCheckedOut::class, $this->eventRegistry->classFor('book.checked-out'));
        $this->assertSame(BookWasReturned::class, $this->eventRegistry->classFor('book.returned'));
    }
}
