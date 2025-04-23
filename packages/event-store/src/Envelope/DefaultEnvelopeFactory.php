<?php

namespace Khronos\EventStore\Envelope;

use Khronos\EventStore\Envelope\Metadata\TimestampEnricher;
use Khronos\EventStore\Registry\Registry;
use Ramsey\Uuid\Uuid;

final readonly class DefaultEnvelopeFactory implements EnvelopeFactory
{
    public function __construct(
        private Registry $eventRegistry,
        private MetadataEnricher $metadataEnricher = new CompositeMetadataEnricher([
            new TimestampEnricher(),
        ]),
    ) {}

    public function wrap(object $event, Metadata $metadata = new Metadata()): Envelope
    {
        $metadata = $metadata->withRequired(
            eventId: Uuid::uuid7(),
            eventType: $this->eventRegistry->eventTypeFor($event::class)
        );

        $metadata = $this->metadataEnricher->enrich($event, $metadata);

        return new Envelope($event, $metadata);
    }
}