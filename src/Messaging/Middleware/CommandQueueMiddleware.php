<?php


namespace Infrastructure\Messaging\Middleware;


use Infrastructure\Messaging\Command;
use Infrastructure\Messaging\MessageDispatcher;
use Infrastructure\Messaging\ImmediateCommand;
use League\Tactician\Middleware;

class CommandQueueMiddleware implements Middleware
{
    /**
     * @var MessageDispatcher
     */
    private $adapter;

    private $exchange;

    /**
     * QueueMiddleware constructor.
     *
     * @param MessageDispatcher $adapter
     * @param string $exchange
     */
    public function __construct(MessageDispatcher $adapter, $exchange = '')
    {
        $this->adapter = $adapter;
        $this->exchange = $exchange;
    }

    /**
     * @param Command $command
     * @param callable $next
     *
     * @return bool
     */
    public function execute($command, callable $next)
    {
        if ($command instanceof ImmediateCommand) {
            return $next($command->getCommand());
        } else {
            $this->adapter->publish(
                json_encode($command->jsonSerialize()),
                [],
                $this->exchange,
                $command->getRoutingKey()
            );

            return true;
        }
    }
}