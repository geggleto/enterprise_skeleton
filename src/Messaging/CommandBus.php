<?php
namespace Infrastructure\Messaging;

interface CommandBus
{
    /**
     * @param Command $command
     *
     * @return void
     */
    public function handle(Command $command);
}