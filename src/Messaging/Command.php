<?php


namespace Infrastructure\Messaging;


interface Command extends \JsonSerializable
{
    /**
     * @return string a globally unique routing key for this command in dot notation
     */
    public function getRoutingKey();

    /**
     * @param array $data the data to be deserialized
     * @return self
     */
    public static function deserialize(array $data);
}