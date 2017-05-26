<?php


namespace Infrastructure\Persistence;

use Infrastructure\Events\DomainEvent;

abstract class AbstractEntity
{
    /** @var DomainEvent[] */
    protected $events;

    /**
     * AbstractEntity constructor.
     */
    public function __construct()
    {
        $this->events = [];
    }

    /**
     * @param DomainEvent $event
     */
    protected function raise(DomainEvent $event) {
        $this->events[] = $event;
    }

    /**
     * @return DomainEvent[]
     */
    public function getEvents() {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}