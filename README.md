# Project Goals
- Event store that allows serialization, metadata handling, etc.
  - Event names should be mappable/resolvable.
- Aggregate repository that simplifies retrieving and hydrating events.
- Projection/event handlers.
- Testing utilities.

## Event Store
```php
$discovery = new ClassDiscovery(
    new ComposerClassMapClassLocator(__DIR__ . '/vendor/composer/autoload_classmap.php')
);

// The event store can be anything that implements the EventStore interface.
// Most people will probably just use the DefaultEventStore since it supports
// drivers and automatically handles the wrapping of domain events in envelopes
// with metadata.
//
// Any framework integration will register the DefaultEventStore to EventStore
// by default.
$eventStore = new DefaultEventStore(
    // The envelope factory wraps a POPO in an envelope with metadata.
    // Most people will use the DefaultEnvelopeFactory which is registered
    // with the container by default.
    envelopeFactory: new DefaultEnvelopeFactory(
        // The event registry maps class FQCNs with event names.
        // The AttributeRegistry is registered by default.
        // An event store driver might also reference
        // the event registry for deserialization.
        eventRegistry: new AttributeRegistry($discovery),

        // Metadata Enricher add info to the message metadata.
        // By default, we add an event ID and event type.
        metadataEnricher: new CompositeMetadataEnricher([
            new TimestampEnricher()
        ])
    ),

    // This is the storage driver for the event store that determines
    // how events are serialized/persisted. We would provide one of
    // these with every framework integration:
    //
    // - new TempestEventStoreDriver()
    // - new LaravelEventStoreDriver()
    // - new SymfonyEventStoreDriver()
    // - etc.
    //
    driver: new InMemoryEventStoreDriver()
);

$eventStore->appendToStream('test-123', new BookWasCheckedOut('123'));
$eventStore->appendToStream('test-123', new BookWasReturned());

foreach ($eventStore->readStream('test-123') as $storedEvent) {
    var_dump($storedEvent->event);
    var_dump($storedEvent->metadata->eventId);
    var_dump($storedEvent->metadata->eventType);
    var_dump($storedEvent->metadata->get('some-custom-key'));
}
```

## Event Sourcing
```php
use Khronos\EventSourcing\AggregateRoot;
use Khronos\EventSourcing\DefaultAggregateRepository;use Khronos\EventSourcing\RecordsEvents;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

// Typically this would be resolved from the container.
// Framework integrations set this up with our default
// event store.
$repository = new DefaultAggregateRepository(...);

// The repository handles retrieving the aggregate
// from our event store.
$book = $repository->findById('123', Book::class);

// We mutate our aggregate which records an
// uncommitted event.
$book->checkout();

// Now we use our repository to save the aggregate
// which records our events to the store and accounts
// for concurrency.
$repository->save($book);

// The stream syntax is not implemented. Just a desired DX.
// A stream resolver might make this: books-{uuid}
#[Stream(name: 'books', partitionBy: 'id')]
final class Book implements AggregateRoote
{
    use RecordsEvents;

    private UuidInterface $id;

    private bool $isCheckedOut = false;

    public static function create(string $name, string $author, ?string $description = null): self
    {
        return new self()->recordThat(new BookWasCreated(
            id: Uuid::uuid7(),
            name: $name,
            author: $author,
            description: $description,
        ));
    }

    public function checkout(): self
    {
        if ($this->isCheckedOut) {
            throw new LogicException('You cannot checkout this book!');
        }

        return $this->recordThat(
            new BookWasCheckedOut($this->id)
        );
    }

    public function return(): self
    {
        return $this->recordThat(
            new BookWasReturned($this->id)
        );
    }

    private function applyBookWasCreated(BookWasCreated $event): void
    {
        $this->id = Uuid::fromString($event->id);
    }

    private function applyBookWasCheckedOut(BookWasCheckedOut $event): void
    {
        $this->isCheckedOut = true;
    }

    private function applyBookWasReturned(BookWasReturned $event): void
    {
        $this->isCheckedOut = false;
    }
}
```

## Event Subscribing
All of this has not been implemented and is desired DX.

```php
// Basically this is syntax sugar that allows us asynchronously
// handle events in a worker. We do this by storing what events have
// been handled in a checkpoint and processing everything past that
// by reading it from the event store in a while loop. 
new EventStreamWorker(eventStore: $store, checkpointStore: $checkpoint)
    ->onlyStreams('books-*')
    ->onlyEvents(BookWasCheckedOut::class)
    ->do(SomeProjector::class)
    ->do(fn (BookWasCheckedOut $event, Metadata $metadata) => echo $event->id)
    ->run();

// Of course, we could also handle event synchronously.
final class SomeEventHandler
{
    #[EventHandler]
    public function handle(BookWasCheckedOut $event, Metadata $metadata): void
    {
        // Update our read model.
    }
}
```

## Extending Functionality
There are a few layers of complexity to the event store implementation that merit detailed explainatino.

### Event Store
The event store is any implementation of `EventSourcing\EventStore\EventStore`. This contract requires a few simple methods for reading and writing domain events. That is, __plain old PHP objects__.

Most applications should be fine using `EventSourcing\EventStore\DefaultEventStore`, which supports swappable drivers for persistence.

### EnvelopeFactory
The envelope factory is any implementation of `EventSourcing\EventStore\Envelope\EnvelopeFactory`. This class handles the wrapping of a domain event into an event store message. This class is also responsible for running that message through metadata enrichment. Custom enrichers can be created to add context to an event, such as a user id or tenant.

### EventStoreDriver
The event store driver is any implementation of `EventSourcing\EventStore\EventStoreDriver`. This contract requires a few simple methods for reading and writing event store messages (`EventSourcing\EventStore\Envelope\Envelope`). This driver is responsible also for the serialization of the event.

