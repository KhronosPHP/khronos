<?php

namespace Khronos\EventStore;

use Khronos\EventStore\Envelope\Envelope;
use Khronos\EventStore\Envelope\EnvelopeFactory;

final readonly class DefaultEventStore implements EventStore
{
    public function __construct(
        private EnvelopeFactory $envelopeFactory,
        private EventStoreDriver $driver,
    ) {}

    public function appendToStream(string $stream, ExpectedVersion $expectedVersion, object ...$events): void
    {
        foreach ($events as $key => $event) {
            $events[$key] = $this->envelopeFactory->wrap($event);
        }

        $this->driver->appendToStream($stream, $expectedVersion, ...$events);
    }

    /**
     * @return Envelope[]
     */
    public function readStream(string $stream): array
    {
        return $this->driver->readStream($stream);
    }
}
