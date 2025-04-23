<?php

namespace Khronos\EventStore;

interface EventStore
{
    public function appendToStream(string $stream, ExpectedVersion $expectedVersion, object ...$events): void;

    public function readStream(string $stream): array;
}