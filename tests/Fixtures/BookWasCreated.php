<?php

namespace Khronos\Tests\Fixtures;

final readonly class BookWasCreated
{
    public function __construct(
        public string $id,
        public string $name,
        public string $author,
        public ?string $description = null,
    ) {}
}