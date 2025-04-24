<?php

namespace Khronos\EventStore\Tests\Unit\EventStore;

use DateTimeImmutable;
use Khronos\EventStore\Envelope\Envelope;
use Khronos\EventStore\Envelope\Metadata;
use Khronos\EventStore\Tests\Unit\Fixtures\BookWasCheckedOut;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class EnvelopeTest extends TestCase
{
    public function test_getting_event_name(): void
    {
        $envelope = new Envelope(
            new BookWasCheckedOut('test', new DateTimeImmutable()),
            new Metadata([
                'event_type' => 'book.checked-out',
            ]),
        );

        $this->assertSame('book.checked-out', $envelope->metadata->eventType);
    }

    public function test_getting_event_name_throws_exception_if_not_set(): void
    {
        $this->expectException(RuntimeException::class);

        $envelope = new Envelope(
            new BookWasCheckedOut('test', new DateTimeImmutable()),
        );

        $envelope->metadata->eventType;
    }
}
