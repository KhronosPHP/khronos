<?php

namespace Khronos\EventStore;

use Khronos\EventStore\Envelope\Envelope;
use RuntimeException;

final class InMemoryEventStoreDriver implements EventStoreDriver
{
    private array $eventStreams = [];

    public function appendToStream(string $stream, ExpectedVersion $expectedVersion, Envelope ...$events): void
    {
        $this->guardStreamVersion($stream, $expectedVersion);

        if (! isset($this->eventStreams[$stream])) {
            $this->eventStreams[$stream] = [];
        }

        array_push($this->eventStreams[$stream], ...$events);
    }

    public function readStream(string $stream): array
    {
        return $this->eventStreams[$stream] ?? [];
    }

    private function guardStreamVersion(string $stream, ExpectedVersion $expectedVersion): void
    {
        if ($expectedVersion->value === -1 && isset($this->streams[$stream])) {
            throw new RuntimeException('Stream already exists');
        }

        if ($expectedVersion->value > -1 && ! isset($this->streams[$stream])) {
            throw new RuntimeException('Stream does not exist');
        }

        if ($expectedVersion->value > -1 && count($this->eventStreams[$stream]) - 1 !== $expectedVersion->value) {
            throw new RuntimeException('Stream version does not match');
        }
    }
}