<?php

namespace Khronos\EventStore;

use Khronos\EventStore\Envelope\Envelope;

interface EventStoreDriver
{
    public function appendToStream(string $stream, ExpectedVersion $expectedVersion, Envelope ...$events): void;

    public function readStream(string $stream): array;
}