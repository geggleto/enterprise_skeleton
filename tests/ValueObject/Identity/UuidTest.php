<?php


namespace Tests\Infrastructure\ValueObject\Identity;


use Infrastructure\ValueObject\Geography\Address;
use Infrastructure\ValueObject\Identity\Uuid;
use Tests\Infrastructure\Base;

class UuidTest extends Base
{
    public function testEquals() {
        $uuid = new Uuid();
        $uuid2 = new Uuid();

        $this->assertTrue(!$uuid->equals($uuid2));

        $uuid3 = clone $uuid;

        $this->assertTrue($uuid->equals($uuid3));

        $address = new Address(
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii()
        );

        $this->assertTrue(!$uuid->equals($address));
    }

    public function testToString() {
        $uuid = new Uuid();

        $this->assertEquals(36, strlen($uuid->getUuid()));

        $this->assertEquals(36, strlen($uuid->toString()));
    }

    public function testConstructor() {
        $uuid = new Uuid();

        $newUuid = new Uuid($uuid->toString());

        $this->assertTrue($uuid->equals($newUuid));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorWithException() {
        $uuid = new Uuid('');
    }
}