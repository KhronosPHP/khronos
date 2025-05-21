<?php

namespace Khronos\EventSourcing\Tests\Unit\Fixtures;

use Khronos\EventSourcing\AggregateRoot;
use Khronos\EventSourcing\RecordsEvents;
use Khronos\EventSourcing\Stream\Stream;

#[Stream('book')]
final class Book implements AggregateRoot
{
    use RecordsEvents;

    public bool $checkedOut = false;

    public function applyBookWasCheckedOut(BookWasCheckedOut $event): void
    {
        $this->checkedOut = true;
    }
}
