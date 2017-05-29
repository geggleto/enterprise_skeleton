<?php


namespace Tests\Infrastructure\Persistence;

use Infrastructure\Persistence\AbstractEntity;
use Tests\Infrastructure\BaseEvent;

class UserEntity extends AbstractEntity
{
    protected $string;

    public function __construct($string = '')
    {
        parent::__construct();

        $this->string = $string;

        $this->raise(new BaseEvent($string));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'string' => $this->string
        ];
    }

    /**
     * @param bool $deleted
     * @return void
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function update(array $data)
    {
        $this->string = $data['string'];
    }

    /**
     * @return array
     */
    static function getBlueprint()
    {
        return [
            'string' => 0
        ];
    }

    /**
     * @return array
     */
    static function getRequiredFields()
    {
        return [
            'string'
        ];
    }
}