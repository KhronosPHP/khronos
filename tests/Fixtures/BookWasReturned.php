<?php

namespace Khronos\Tests\Fixtures;

use Khronos\Discovery\Event;

#[Event('book.returned')]
final readonly class BookWasReturned
{
    public function __construct(public string $id)
    {}
}