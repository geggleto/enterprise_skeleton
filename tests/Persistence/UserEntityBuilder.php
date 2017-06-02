<?php


namespace Tests\Infrastructure\Persistence;


use Infrastructure\Persistence\EntityBuilder;

class UserEntityBuilder implements EntityBuilder
{
    /** @var string */
    protected $string;

    /**
     * UserEntityBuilder constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->string = $data['string'];
    }

    /**
     * @return UserEntity
     */
    public function getEntity()
    {
        return new UserEntity($this->string);
    }

}