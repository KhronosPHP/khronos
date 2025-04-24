<?php

namespace Khronos\EventStore\Envelope;

use RuntimeException;

final class Metadata
{
    public string $eventId {
        get => $this->metadata['event_id'] ?? throw new RuntimeException('Event ID is not set');
    }

    public string $eventType {
        get => $this->metadata['event_type'] ?? throw new RuntimeException('Event type is not set');
    }

    public function __construct(
        private(set) array $metadata = [],
    ) {}

    public function withRequired(string $eventId, string $eventType): Metadata
    {
        return $this->including([
            'event_id' => $eventId,
            'event_type' => $eventType,
        ]);
    }

    public function with(string $key, mixed $value): Metadata
    {
        $clone = clone $this;

        $clone->metadata[$key] = $value;

        return $clone;
    }

    public function including(array $metadata): Metadata
    {
        $clone = clone $this;

        $clone->metadata = array_merge($clone->metadata, $metadata);

        return $clone;
    }

    public function get(string $key): mixed
    {
        return $this->metadata[$key] ?? null;
    }

    public function all(): array
    {
        return $this->metadata;
    }

    public function __serialize(): array
    {
        return $this->metadata;
    }

    public function __unserialize(array $data): void
    {
        $this->metadata = $data;
    }
}
