<?php


namespace Tests\Infrastructure\Persistence;


use Infrastructure\Persistence\EntityFactory;
use Tests\Infrastructure\Base;

class EntityFactoryTest extends Base
{
    public function testMakeEntity()
    {
        $args = [
            'string' => bin2hex(random_bytes(8))
        ];

        $user = EntityFactory::make(UserEntity::class, $args);

        $this->assertInstanceOf(UserEntity::class, $user);
    }
}