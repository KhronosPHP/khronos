<?php

namespace Khronos\EventStore\Tests\Unit\EventStore;

use Khronos\EventStore\Envelope\DefaultEnvelopeFactory;
use Khronos\EventStore\Envelope\Envelope;
use Khronos\EventStore\Registry\StaticMapRegistry;
use Khronos\EventStore\Tests\Unit\Fixtures\BookWasCheckedOut;
use PHPUnit\Framework\TestCase;

final class DefaultEnvelopeFactoryTest extends TestCase
{
    public function test_it_creates_envelope(): void
    {
        $factory = new DefaultEnvelopeFactory(
            eventRegistry: new StaticMapRegistry([
                BookWasCheckedOut::class => 'book.checked-out',
            ]),
        );

        $envelope = $factory->wrap(
            new BookWasCheckedOut('123', new \DateTimeImmutable()),
        );

        $this->assertInstanceOf(Envelope::class, $envelope);
        $this->assertIsString($envelope->metadata->eventId);
        $this->assertIsString($envelope->metadata->eventType);
    }
}
