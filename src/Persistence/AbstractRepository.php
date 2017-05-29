<?php
namespace Infrastructure\Persistence;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Infrastructure\Events\EventDispatcher;
use Infrastructure\ValueObject\Identity\Uuid;

abstract class AbstractRepository
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var  EventDispatcher */
    protected $dispatcher;

    /**
     * AbstractRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param EventDispatcher $dispatcher
     */
    public function __construct(EntityManagerInterface $entityManager, EventDispatcher $dispatcher)
    {
        $this->entityManager = $entityManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param AbstractEntity $abstractEntity
     *
     * @return bool
     */
    public function store(AbstractEntity $abstractEntity)
    {
        try {
            $this->entityManager->persist($abstractEntity);
            $this->entityManager->flush();

            $events = $abstractEntity->getEvents();
            foreach ($events as $event) {
                $this->dispatcher->dispatch($event);
            }

            return true;
        } catch (ORMException $exception) {
            return false;
        }
    }

    /**
     * @param AbstractEntity $entity
     */
    public function remove(AbstractEntity $entity)
    {
        $entity->setDeleted(true);

        $this->store($entity);
    }

    /**
     * @param Uuid $uuid
     * @return AbstractEntity
     */
    public function Unremove(Uuid $uuid)
    {
        $entity = $this->find($uuid);
        $entity->setDeleted(false);
        $this->store($entity);

        return $entity;
    }

    /**
     * @param Uuid $uuid
     * @return AbstractEntity
     */
    abstract public function find(Uuid $uuid);
}