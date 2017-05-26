<?php
namespace Infrastructure\Persistence;

use Doctrine\ORM\ORMException;
use Infrastructure\Events\EventDispatcher;

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