<?php

namespace Khronos\EventStore\Envelope\Metadata;

use DateTime;
use DateTimeImmutable;
use Khronos\EventStore\Envelope\Metadata;
use Khronos\EventStore\Envelope\MetadataEnricher;

final class TimestampEnricher implements MetadataEnricher
{
    public function enrich(object $event, Metadata $metadata): Metadata
    {
        return $metadata->with('recorded_at', new DateTimeImmutable()->format(DateTime::ATOM));
    }
}
