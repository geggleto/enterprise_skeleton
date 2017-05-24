<?php
namespace Infrastructure\Messaging\Middleware;

use Doctrine\ORM\EntityManager;
use Infrastructure\Messaging\Command;
use League\Tactician\Middleware;


/**
 * Class EntityManagerMiddleware
 *
 */
class EntityManagerMiddleware implements Middleware
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * EntityManagerMiddleware constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Command $command
     * @param callable $next
     *
     * @return bool
     */
    public function execute($command, callable $next)
    {
        $this->entityManager->clear();
        return $next($command);
    }
}