<?php

namespace Khronos\Tests\EventStore;

use DateTimeImmutable;
use Khronos\EventStore\Envelope\Envelope;
use Khronos\EventStore\Envelope\Metadata;
use Khronos\EventStore\ExpectedVersion;
use Khronos\EventStore\InMemoryEventStoreDriver;
use Khronos\Tests\Fixtures\BookWasCheckedOut;
use Khronos\Tests\Fixtures\BookWasReturned;
use PHPUnit\Framework\TestCase;

final class InMemoryEventStoreTest extends TestCase
{
    public function test_writing_events()
    {
        $eventsBefore = [
            new Envelope(
                new BookWasCheckedOut('123', new DateTimeImmutable()),
                new Metadata([
                    'event_id' => '123',
                    'event_type' => 'book.checked-out',
                ])
            ),
            new Envelope(
                new BookWasReturned('123'),
                new Metadata([
                    'event_id' => '124',
                    'event_type' => 'book.returned',
                ])
            )
        ];

        $eventsAfter = [
            $eventsBefore[0],
            $eventsBefore[1],
            new Envelope(
                new BookWasCheckedOut('123', new DateTimeImmutable()),
                new Metadata([
                    'event_id' => '125',
                    'event_type' => 'book.checked-out',
                ])
            ),
        ];

        $store = new InMemoryEventStoreDriver();

        $store->appendToStream('test-stream', ExpectedVersion::any(), ...$eventsBefore);

        $this->assertEquals(
            $store->readStream('test-stream'), $eventsBefore
        );

        $store->appendToStream('test-stream', ExpectedVersion::any(), $eventsAfter[2]);

        $this->assertEquals(
            $store->readStream('test-stream'), $eventsAfter
        );
    }
}