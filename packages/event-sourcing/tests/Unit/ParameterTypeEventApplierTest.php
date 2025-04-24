<?php

namespace Khronos\EventSourcing\Tests\Unit;

use Khronos\EventSourcing\ParameterTypeEventApplier;
use Khronos\EventSourcing\Tests\Unit\Fixtures\Book;
use Khronos\EventSourcing\Tests\Unit\Fixtures\BookWasCheckedOut;
use PHPUnit\Framework\TestCase;

final class ParameterTypeEventApplierTest extends TestCase
{
    public function test_event_is_applied(): void
    {
        $aggregate = new Book();
        $applier = new ParameterTypeEventApplier();

        $applier->apply($aggregate, new BookWasCheckedOut());

        $this->assertTrue($aggregate->checkedOut);
    }
}
