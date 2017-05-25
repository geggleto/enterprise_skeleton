<?php
namespace Infrastructure\Messaging\Adapters;


use Infrastructure\Messaging\MessageDispatcher;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQ implements MessageDispatcher
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel;

    /** @var string  */
    private $host;

    /** @var string  */
    private $vhost;

    /** @var string  */
    private $userName;

    /** @var string  */
    private $password;

    /** @var int  */
    private $port;

    /**
     * PHPAMQPRabbitMQ constructor.
     *
     * @param string $host
     * @param string $vhost
     * @param string $userName
     * @param string $password
     * @param int $port
     */
    public function __construct($host, $vhost, $userName, $password, $port = 5672)
    {
        $this->host = $host;
        $this->vhost = $vhost;
        $this->userName = $userName;
        $this->password = $password;
        $this->port = $port;
    }

    /**
     * connects to RabbitMQ
     */
    private function connect()
    {
        if (!$this->connection || !$this->connection->isConnected()) {
            $this->connection = new AMQPStreamConnection(
                $this->host,
                $this->port,
                $this->userName,
                $this->password,
                $this->vhost
            );
            $this->channel = $this->connection->channel();
        }
    }

    /**
     * @return AMQPStreamConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }



    /**
     * @inheritDoc
     */
    public function publish($body, array $headers = [], $exchange = '*', $routingKey = '*')
    {
        $this->connect();

        $message = new AMQPMessage($body, $headers);

        try {
            $this->channel->basic_publish(
                $message,
                $exchange,
                $routingKey
            );

            return true;
        }
        catch (\Exception $e) {
            return false;
        }
    }
}