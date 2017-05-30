<?php


namespace Infrastructure\Http\Controller;


use Infrastructure\Messaging\CommandBus;

abstract class CommandController
{
    protected $commandBus;

    public function __construct(CommandBus $bus)
    {
        $this->commandBus = $bus;
    }
}