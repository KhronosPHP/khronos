<?php

namespace Khronos\EventStore;

use UnexpectedValueException;

final class ExpectedVersion
{
    public static function any(): self
    {
        return new self(-1);
    }

    public static function noStream(): self
    {
        return new self(0);
    }

    public static function exactly(int $version): self
    {
        return new self($version);
    }

    public function __construct(
        private(set) ?int $value,
    ) {
        if ($value < -1) {
            throw new UnexpectedValueException('Expected version must be greater than or equal to -1, got ' . $value);
        }
    }

    public function equals(self $expectedVersion): bool
    {
        return $this->value === $expectedVersion->value;
    }
}
