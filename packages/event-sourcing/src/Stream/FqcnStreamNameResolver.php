<?php

namespace Khronos\EventSourcing\Stream;

final class FqcnStreamNameResolver implements StreamNameResolver
{
    public function resolve(object $aggregate): string
    {
        return $aggregate::class;
    }
}
