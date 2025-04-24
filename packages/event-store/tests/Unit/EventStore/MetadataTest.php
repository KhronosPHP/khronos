<?php

namespace Khronos\EventStore\Tests\Unit\EventStore;

use Khronos\EventStore\Envelope\Metadata;
use PHPUnit\Framework\TestCase;

class MetadataTest extends TestCase
{
    public function test_with_required(): void
    {
        $metadata = new Metadata();

        $metadata = $metadata->withRequired(
            eventId: 'test-event-id',
            eventType: 'test-event-type',
        );

        $this->assertSame('test-event-id', $metadata->eventId);
        $this->assertSame('test-event-type', $metadata->eventType);
    }

    public function test_with_metadata(): void
    {
        $metadata1 = new Metadata();
        $metadata2 = $metadata1->with('test-key', 'test-value');

        $this->assertNotSame($metadata1, $metadata2);
    }

    public function test_including_metadata(): void
    {
        $metadata1 = new Metadata([
            'test-key-1' => 'test-value-1',
        ]);

        $metadata2 = $metadata1->including([
            'test-key-2' => 'test-value-2',
            'test-key-3' => 'test-value-3',
        ]);

        $this->assertNotSame($metadata1, $metadata2);
        $this->assertEqualsCanonicalizing(
            [
                'test-key-1' => 'test-value-1',
                'test-key-2' => 'test-value-2',
                'test-key-3' => 'test-value-3',
            ],
            $metadata2->all(),
        );
    }

    public function test_getting_key(): void
    {
        $metadata = new Metadata([
            'test-key-1' => 'test-value-1',
        ]);

        $this->assertSame('test-value-1', $metadata->get('test-key-1'));
        $this->assertNull($metadata->get('test-key-2'));
    }

    public function test_serializing(): void
    {
        $metadata = new Metadata([
            'test-key-1' => 'test-value-1',
            'test-key-2' => 'test-value-2',
        ]);

        $serialized = serialize($metadata);

        $this->assertEquals($metadata, unserialize($serialized));
    }
}
