<?php

namespace Khronos\EventStore\Envelope;

final readonly class Envelope
{
    public function __construct(
        public object $event,
        public Metadata $metadata = new Metadata(),
    ) {}
}