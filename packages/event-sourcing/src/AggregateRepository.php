<?php

namespace Khronos\EventSourcing;

interface AggregateRepository
{
    /**
     * @template AggregateType
     *
     * @param class-string<AggregateType> $aggregateRootType
     *
     * @return AggregateType
     */
    public function findById(string $aggregateRootId, string $aggregateRootType): object;

    public function save(AggregateRoot $aggregateRoot): void;
}
