<?php

namespace Khronos\EventSourcing\Stream;

use UnexpectedValueException;

final class AttributeStreamNameResolver implements StreamNameResolver
{
    public function resolve(object $aggregate): string
    {
        $reflection = new \ReflectionClass($aggregate);

        // TODO(aidan-casey): Clean this up.
        $attribute = $reflection->getAttributes(Stream::class)[0] ?? throw new UnexpectedValueException(
            'No stream attribute found on aggregate'
        );

        return $attribute->newInstance()->name;
    }
}