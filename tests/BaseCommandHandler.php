<?php


namespace Tests\Infrastructure;


use Tests\Infrastructure\Messaging\Adapters\TacticianTest;

class BaseCommandHandler
{
    protected $test;

    public function __construct(TacticianTest $tacticianTest)
    {
        $this->test = $tacticianTest;
    }

    public function handle(BaseCommand $command) {
        $this->test->setReceived($command->getCommandName());
    }
}