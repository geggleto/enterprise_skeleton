<?php
namespace Infrastructure\Persistence;

use Infrastructure\Events\DomainEvent;
use Infrastructure\ValueObject\Identity\Uuid;
use Infrastructure\Persistence\Entity as InfrastructureEntity;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;

/**
 * Class AbstractEntity
 * @package Infrastructure\Persistence
 * @Entity
 */
abstract class AbstractEntity implements InfrastructureEntity
{
    /**
     * @var Uuid
     * @Id()
     * @Column(type="guid")
     */
    protected $uuid;

    /**
     * @var bool
     * @Column(type="boolean")
     */
    protected $deleted;


    /** @var DomainEvent[] */
    private $events;

    /**
     * AbstractEntity constructor.
     */
    public function __construct()
    {
        $this->events = [];
        $this->deleted = false;
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

    /**
     * @return Uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param Uuid $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

}