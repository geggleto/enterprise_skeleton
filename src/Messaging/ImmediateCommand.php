<?php

namespace Infrastructure\Messaging;

/**
 * Class ImmediateCommand
 *
 * This special command will be executed in the same process as the HTTP Request
 * It is meant to wrap around a command to ensure it does not go out over the messaging
 * adapter
 *
 * @package Infrastructure\Messaging
 */
class ImmediateCommand implements Command
{
    /**
     * @var Command
     */
    private $command;

    /**
     * QueuedCommand constructor.
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @return Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @inheritDoc
     */
    public function getCommandName()
    {
        return $this->getCommand()->getCommandName();
    }

    /**
     * @inheritDoc
     */
    function jsonSerialize()
    {
        return [
            'command' => $this->getCommand()->jsonSerialize()
        ];
    }

    /**
     * @inheritDoc
     */
    public static function deserialize(array $data)
    {
        throw new \Exception("If you're using deserialize here, then you're doing something wrong! ");
    }


}