<?php

namespace Khronos\Tests\Fixtures;

use Khronos\EventSourcing\AggregateRoot;
use Khronos\EventSourcing\RecordsEvents;
use LogicException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Book implements AggregateRoot
{
    use RecordsEvents;

    private UuidInterface $id;

    private bool $isCheckedOut = false;

    public static function create(string $name, string $author, ?string $description = null): self
    {
        return new self()->recordThat(new BookWasCreated(
            id: Uuid::uuid7(),
            name: $name,
            author: $author,
            description: $description,
        ));
    }

    public function checkout(): self
    {
        if ($this->isCheckedOut) {
            throw new LogicException('You cannot checkout this book!');
        }

        return $this->recordThat(
            new BookWasCheckedOut($this->id)
        );
    }

    public function return(): self
    {
        return $this->recordThat(
            new BookWasReturned($this->id)
        );
    }

    private function applyBookWasCreated(BookWasCreated $event): void
    {
        $this->id = Uuid::fromString($event->id);
    }

    private function applyBookWasCheckedOut(BookWasCheckedOut $event): void
    {
        $this->isCheckedOut = true;
    }

    private function applyBookWasReturned(BookWasReturned $event): void
    {
        $this->isCheckedOut = false;
    }
}