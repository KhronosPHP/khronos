<?php

namespace Khronos\EventSourcing\Stream;

interface StreamNameResolver
{
    public function resolve(object $aggregate): string;
}