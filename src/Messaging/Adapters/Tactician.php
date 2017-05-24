<?php
namespace Infrastructure\Messaging\Adapters;


use Infrastructure\Messaging\Command;
use Infrastructure\Messaging\CommandBus;
use League\Tactician\CommandBus as BaseBus;

class Tactician implements CommandBus
{
    /**
     * @var BaseBus
     */
    private $bus;

    /**
     * @param BaseBus $bus
     */
    public function __construct(BaseBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @inheritdoc
     */
    public function handle(Command $command)
    {
        $this->bus->handle($command);
    }
}