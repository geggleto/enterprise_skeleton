<?php
namespace Infrastructure\Events\Adapters;

use Infrastructure\Events\DomainEvent;
use Interop\Container\ContainerInterface;
use Infrastructure\Events\EventDispatcher;


class CustomEventDispatcher implements EventDispatcher
{
    /** @var array  */
    private $mapping;

    /** @var ContainerInterface  */
    protected $container;

    /** @var array */
    protected $middleware;

    /**
     * CustomEventDispatcher constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->mapping = [];
        $this->middleware = [];
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }


    /**
     * @inheritDoc
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function dispatch(DomainEvent $event)
    {
        if (is_array($this->mapping[$event->getEventName()])) {
            foreach ($this->mapping[$event->getEventName()] as $subscriber) {
                if (is_string($subscriber[0])) { //If we need to pull the object from the container
                    //call_user_func_array([$this->container->get($subscriber[0]), $subscriber[1]], [$event]);

                    $sub = $this->container->get($subscriber[0]);
                    $sub->{$subscriber[1]}($event);

                } else { // Else we assume it's already a callable
                    $subscriber($event);
                }
            }
        }

        foreach ($this->middleware as $k => $subscriber) {
            if (is_string($subscriber[0])) { //If we need to pull the object from the container
                //call_user_func_array([$this->container->get($subscriber[0]), $subscriber[1]], [$event]);

                $middleware = $this->container->get($subscriber[0]);
                $middleware->{$subscriber[1]}($event);

            } else { // Else we assume it's already a callable
                $subscriber($event);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function addListener($eventName, $listener)
    {
        $this->mapping[$eventName][] = $listener;
    }

    /**
     * @param array $listener
     */
    public function addMiddleware(array $listener) {
        $this->middleware[] = $listener;
    }

    /**
     * @param $eventName
     */
    public function removeListeners($eventName) {
        unset($this->mapping[$eventName]);
    }

    /**
     * @param $eventName
     * @return array
     */
    public function getListeners($eventName) {
        return isset($this->mapping[$eventName]) ? $this->mapping[$eventName] : [];
    }
}