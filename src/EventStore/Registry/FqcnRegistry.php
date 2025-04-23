<?php

namespace Khronos\EventStore\Registry;

use const E_USER_NOTICE;

/**
 * We recommend using the attribute registry instead!
 */
final class FqcnRegistry implements Registry
{
    public function classFor(string $eventType): string
    {
        return $eventType;
    }

    public function eventTypeFor(string $class): string
    {
        return $class;
    }
}