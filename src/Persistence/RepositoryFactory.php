<?php


namespace Infrastructure\Persistence;


use Psr\Container\ContainerInterface;

class RepositoryFactory
{
    /** @var ContainerInterface */
    protected $container;

    /** @var array  */
    protected $mappings;

    /**
     * RepositoryFactory constructor.
     *
     * @param ContainerInterface $container
     * @param array $mappings
     */
    public function __construct(ContainerInterface $container, array $mappings = [])
    {
        $this->container = $container;
        $this->mappings = $mappings;
    }

    /**
     * @param string $entity
     * @return AbstractRepository|false
     */
    public function fetch($entity = '')
    {
        if ($this->container->has($this->mappings[$entity])) {
            return $this->container->get($this->mappings[$entity]);
        }
        return false;
    }
}