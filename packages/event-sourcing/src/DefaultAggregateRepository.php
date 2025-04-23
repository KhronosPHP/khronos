<?php

namespace Khronos\EventSourcing;

use Khronos\EventSourcing\AggregateRoot as TAggregate;
use Khronos\EventStore\EventStore;
use Khronos\EventStore\ExpectedVersion;

final class DefaultAggregateRepository implements AggregateRepository
{
    public function __construct(
        private readonly EventStore $eventStore
    ) {}

    /**
     * @template TAggregate of AggregateRoot
     * @param string $aggregateRootId
     * @param class-string<TAggregate> $aggregateRootType
     * @return TAggregate
     */
    public function findById(string $aggregateRootId, string $aggregateRootType)
    {
        $events = $this->eventStore->readStream('test-stream');

        return $aggregateRootType::reconstituteFromHistory($events);
    }

    public function save(AggregateRoot $aggregateRoot): void
    {
        $events = $aggregateRoot->_recordedEvents;
        $version = $aggregateRoot->_version;

        if (empty($events)) {
            return;
        }

        $expectedVersion = ExpectedVersion::exactly($version - count($events));

        $this->eventStore->appendToStream('test-stream', $expectedVersion, ...$events);
    }
}