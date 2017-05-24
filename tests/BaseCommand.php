<?php
namespace Tests\Infrastructure;


use Infrastructure\Messaging\Command;


class BaseCommand implements Command
{
    protected $name;

    public function __construct($name = '')
    {
        $this->name = $name;
    }

    /**
     * @return string a globally unique routing key for this command in dot notation
     */
    public function getCommandName()
    {
        return $this->name;
    }

    /**
     * @param array $data the data to be deserialized
     * @return self
     */
    public static function deserialize(array $data)
    {
        return new BaseCommand($data['name']);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'name' => $this->name
        ];
    }
}