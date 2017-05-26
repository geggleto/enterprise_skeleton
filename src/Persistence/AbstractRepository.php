<?php


namespace Infrastructure\Persistence;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Infrastructure\Events\EventDispatcher;

abstract class AbstractRepository
{
    /** @var EntityManager */
    protected $entityManager;

    /** @var  EventDispatcher */
    protected $dispatcher;

    /**
     * AbstractRepository constructor.
     *
     * @param EntityManager $entityManager
     * @param EventDispatcher $dispatcher
     */
    public function __construct(EntityManager $entityManager, EventDispatcher $dispatcher)
    {
        $this->entityManager = $entityManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param AbstractEntity $abstractEntity
     *
     * @return bool
     */
    protected function persist(AbstractEntity $abstractEntity) {
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
}