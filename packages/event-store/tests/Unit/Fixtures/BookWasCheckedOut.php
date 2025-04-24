<?php

namespace Khronos\EventStore\Tests\Unit\Fixtures;

use Khronos\Discovery\Event;

#[Event('book.checked-out')]
final readonly class BookWasCheckedOut
{
    public function __construct(
        public string $id,
    ) {}
}
