<?php

namespace Khronos\EventStore\Envelope;

final class CompositeMetadataEnricher implements MetadataEnricher
{
    /**
     * @param MetadataEnricher[] $enrichers
     */
    public function __construct(
        private readonly array $enrichers = [],
    ) {}

    public function enrich(object $event, Metadata $metadata): Metadata
    {
        foreach ($this->enrichers as $enricher) {
            $metadata = $enricher->enrich($event, $metadata);
        }

        return $metadata;
    }
}