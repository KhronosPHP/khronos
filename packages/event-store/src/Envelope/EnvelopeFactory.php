<?php

namespace Khronos\EventStore\Envelope;

interface EnvelopeFactory
{
    public function wrap(object $event, Metadata $metadata): Envelope;
}
