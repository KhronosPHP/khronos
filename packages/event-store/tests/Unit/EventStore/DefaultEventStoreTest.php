<?php

namespace Khronos\EventStore\Tests\Unit\EventStore;

use Khronos\EventStore\DefaultEventStore;
use Khronos\EventStore\Envelope\DefaultEnvelopeFactory;
use Khronos\EventStore\ExpectedVersion;
use Khronos\EventStore\InMemoryEventStoreDriver;
use Khronos\EventStore\Registry\StaticMapRegistry;
use Khronos\EventStore\Tests\Unit\Fixtures\BookWasCheckedOut;
use Khronos\EventStore\Tests\Unit\Fixtures\BookWasReturned;
use PHPUnit\Framework\TestCase;

final class DefaultEventStoreTest extends TestCase
{
    public function test_writing_events(): void
    {
        $driver = new InMemoryEventStoreDriver();
        $store = new DefaultEventStore(
            new DefaultEnvelopeFactory(new StaticMapRegistry([
                BookWasCheckedOut::class => 'book.checked-out',
                BookWasReturned::class => 'book.returned',
            ])),
            $driver,
        );

        $event1 = new BookWasCheckedOut('123', new \DateTimeImmutable());
        $event2 = new BookWasReturned('123');
        $event3 = new BookWasCheckedOut('123', new \DateTimeImmutable());

        $store->appendToStream('test-stream', ExpectedVersion::any(), $event1, $event2, $event3);

        $storedEvents = $store->readStream('test-stream');

        $this->assertEquals($storedEvents[0]->event, $event1);
        $this->assertEquals($storedEvents[1]->event, $event2);
        $this->assertEquals($storedEvents[2]->event, $event3);
    }
}
