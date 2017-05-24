<?php


namespace Tests\Infrastructure;


use Infrastructure\Events\DomainEvent;

class BaseEventHandler
{
    /** @var DomainEvent */
    protected $event;

    public function __construct()
    {
        $this->event = null;
    }

    public function handle(DomainEvent $event) {
        $this->event = $event;
    }

    /**
     * @return DomainEvent|null
     */
    public function getEvent() {
        return $this->event;
    }
}