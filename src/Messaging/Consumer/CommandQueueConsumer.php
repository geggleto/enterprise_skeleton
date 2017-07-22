<?php
namespace Infrastructure\Messaging\Consumer;

use Bunny\Channel;
use Bunny\Message;
use Doctrine\ORM\EntityManager;
use Infrastructure\Messaging\Command;
use Infrastructure\Messaging\CommandBus;
use Infrastructure\Messaging\ImmediateCommand;
use Monolog\Logger;
use Bunny\Client;


class CommandQueueConsumer
{
    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var array the full class name of the command expected to be received
     */
    private $commandMappings;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var string
     */
    private $exchangeName;

    /**
     * @var string
     */
    private $deadLetterExchangeName;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        Channel $channel,
        $commandMappings,
        CommandBus $commandBus,
        $exchangeName,
        $deadLetterExchangeName,
        Logger $logger,
        EntityManager $entityManager
    )
    {
        $this->channel = $channel;
        $this->commandMappings = $commandMappings;
        $this->commandBus = $commandBus;
        $this->exchangeName = $exchangeName;
        $this->deadLetterExchangeName = $deadLetterExchangeName;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function run(
        $routingKey, $queueName, $queueDlx
    ) {

        $this->channel->exchangeDeclare($this->exchangeName, 'topic', false, true);
        $this->channel->exchangeDeclare($this->deadLetterExchangeName, 'topic', false, true);

        //define our DLX which is based off of the routing key name. This is for clarity.
        $dlxQueueName = $queueDlx;
        $this->channel->queueDeclare($dlxQueueName);
        $this->channel->queueBind($dlxQueueName, $this->deadLetterExchangeName, $routingKey);

        //NOTE our Queue name will always be the same as the routing key. This is for clarity.
        $this->channel->queueDeclare($queueName, '', true, false, false, false, [
            'x-dead-letter-exchange' => $this->deadLetterExchangeName
        ]);
        $this->channel->queueBind($queueName, $this->exchangeName, $routingKey);

        $startTime = time();

        $this->channel->run(
            function (Message $message, Channel $channel, Client $bunny) use ($startTime, $routingKey) {

                $pid = getmypid();
                $memory = memory_get_usage(true);
                $this->logger->debug("{$pid} - {$memory} - Pulled a message from the queue with routing key {$routingKey}: " . $message->content);

                if (time() - $startTime > 3550) {
                    $this->logger->debug("{$pid} Ending process after running for 3550 seconds");
                    $channel->nack($message, false, true);
                    die("Quitting after 3550 seconds...");
                }
                else if ($this->entityManager->isOpen() !== true) {
                    $this->logger->debug("{$pid} Ending process because the entity manager is closed");
                    die("Quitting as the entity manager is closed");
                }

                //todo check for exception being thrown
                //e.g., Failed exception (nack), retry later exception (with # attempts & backoff?).
                $success = $this->handleMessage($message); // Handle your message here

                if ($success) {
                    $this->logger->debug("{$pid} message successfully processed. Acking");
                    $channel->ack($message); // Acknowledge message
                    $this->logger->debug("{$pid} Message has been acked");
                    return;
                }

                $memory = memory_get_usage(true);

                $this->logger->error("{$pid}  - {$memory} - Unable to successfully process message. Nacking");
                //todo, if the exception is to requeue, we have 'true' as third parameter
                $channel->nack($message, false, false); // Mark message fail, message will be redelivered

                $this->logger->error("{$pid} Message has been nacked");
                die("Killing consumer as the handler threw an exception");
            },
            $queueName
        );
    }

    /**
     * @param Message $message
     *
     * @return bool
     */
    private function handleMessage(Message $message) {

        $body = $message->content;
        $decoded = json_decode($body, true);

        /**
         * deserialize our original command
         * @var Command $className
         */
        $className = $this->commandMappings[$message->routingKey]['command'];
        $originalCommand = $className::deserialize($decoded);

        //re-wrap inside a QueuedCommand so that it won't get re-queued and send off to command bus
        $rabbitMQCommand = new ImmediateCommand($originalCommand);

        try {
            $this->commandBus->handle($rabbitMQCommand);
            return true;
        }
        catch (\Exception $e) {
            $pid = getmypid();
            //This is less than ideal... we should maybe throw this as an event to put into the tradesii_events table.
            $this->logger->addError(__METHOD__ . ":{$pid}  Error handling queued command with routing key " . $message->routingKey . " and error message: " . $e->getMessage(), $e->getTrace());

            return false;
        }
    }
}