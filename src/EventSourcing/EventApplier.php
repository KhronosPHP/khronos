<?php

namespace Khronos\EventSourcing;

interface EventApplier
{
    public function apply(object $aggregate, object $event): void;
}