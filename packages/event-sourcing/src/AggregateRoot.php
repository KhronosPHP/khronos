<?php

namespace Khronos\EventSourcing;

interface AggregateRoot
{
    public array $_recordedEvents {
        get;
    }
    public int $_version {
        get;
    }

    public static function reconstituteFromHistory(array $events): self;
}
