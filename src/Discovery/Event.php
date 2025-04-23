<?php

namespace Khronos\Discovery;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Event
{
    public function __construct(private(set) string $name, private(set) int $version = 1)
    {}

    public function __toString(): string
    {
        return sprintf('%s.v%d', $this->name, $this->version);
    }
}