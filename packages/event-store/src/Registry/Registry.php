<?php

namespace Khronos\EventStore\Registry;

interface Registry
{
    public function classFor(string $eventType): string;

    public function eventTypeFor(string $class): string;
}
