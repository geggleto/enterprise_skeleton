<?php


namespace Tests\Infrastructure\Persistence;


use Tests\Infrastructure\Base;

class AbstractEntityTest extends Base
{
    public function testAbstractEntity() {
        $value = bin2hex(random_bytes(8));

        $user = new UserEntity($value);

        $this->assertCount(1, $user->getEvents());
    }
}