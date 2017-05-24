<?php


namespace Tests\Infrastructure;


use Infrastructure\Events\DomainEvent;

class BaseEvent implements DomainEvent
{
    protected $eventName;

    public function __construct($eventName = '')
    {
        $this->eventName = $eventName;
    }

    public static function deserialize(array $body)
    {
        return new BaseEvent($body['event_name']);
    }

    public function getEventName()
    {
        return $this->eventName;
    }

    function jsonSerialize()
    {
        return [
            'event_name' => $this->eventName
        ];
    }

}