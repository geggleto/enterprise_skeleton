<?php


namespace Tests\Infrastructure\Messaging;


use Infrastructure\Messaging\ImmediateCommand;
use Tests\Infrastructure\Base;
use Tests\Infrastructure\BaseCommand;

class ImmediateCommandTest extends Base
{
    /** @var  ImmediateCommand */
    protected $command;

    /** @var  string */
    protected $commandName;

    /** @var  BaseCommand */
    protected $baseCommand;


    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->commandName = bin2hex(random_bytes(8));

        $this->baseCommand = new BaseCommand($this->commandName);

        $this->command = new ImmediateCommand($this->baseCommand);
    }

    public function testSerialization() {

        $serializedCommand = $this->command->jsonSerialize();
        $this->assertArrayHasKey('command', $serializedCommand);
        $this->assertSame($this->baseCommand->jsonSerialize(), $serializedCommand['command']);
    }

    public function testDeserialization() {
        $this->expectException(\RuntimeException::class);

        $immediateCommand = ImmediateCommand::deserialize(['command' => []]);
    }

    public function testGetters() {
        $this->assertEquals($this->commandName, $this->command->getCommandName());
        $this->assertSame($this->baseCommand->jsonSerialize(), $this->command->getCommand()->jsonSerialize());
    }
}