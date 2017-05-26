<?php


namespace Infrastructure\Persistence;


use Infrastructure\Events\DomainEvent;

abstract class AbstractEntity
{
    protected $events;

    public function __construct()
    {
        $this->events = [];
    }

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