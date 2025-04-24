<?php

namespace Khronos\EventStore\Envelope;

interface MetadataEnricher
{
    public function enrich(object $event, Metadata $metadata): Metadata;
}
