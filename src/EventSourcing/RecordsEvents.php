<?php

namespace Khronos\EventSourcing;

trait RecordsEvents
{
    private(set) array $_recordedEvents = [];

    private(set) int $_version = 0;

    public static function reconstituteFromHistory(array $events): self
    {
        $instance = new static();

        foreach ($events as $event) {
            $instance->apply($event);
        }

        return $instance;
    }

    protected function recordThat(object $event): self
    {
        $this->apply($event);
        $this->_recordedEvents[] = $event;

        return $this;
    }

    private function apply(object $event): void
    {
        new ParameterTypeEventApplier()->apply($this, $event);
        ++$this->_version;
    }
}