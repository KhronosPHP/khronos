<?php

namespace Khronos\EventSourcing\Stream;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Stream
{
    public function __construct(
        public readonly string $name,
    ) {}
}
