<?php


namespace Tests\Infrastructure\Persistence;

use Infrastructure\Persistence\AbstractEntity;
use Tests\Infrastructure\BaseEvent;

class UserEntity extends AbstractEntity
{
    public function __construct($string = '')
    {
        parent::__construct();

        $this->raise(new BaseEvent($string));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [];
    }

    /**
     * @param bool $deleted
     * @return void
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }
}