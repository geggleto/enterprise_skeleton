<?php
namespace Tests\Infrastructure\ValueObject\Geography;


use Infrastructure\ValueObject\Geography\Address;
use Tests\Infrastructure\Base;
use Tests\Infrastructure\BaseValueObject;

class AddressTest extends Base
{
    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    protected function generator()
    {
        return new Address(
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii(),
            \Faker\Provider\Address::randomAscii()
        );
    }

    public function testEquals()
    {
        $address = $this->generator();
        $this->assertTrue($address->equals($address));

        return $address;
    }

    /**
     * @param Address $address
     *
     * @depends testEquals
     */
    public function testSerialization(Address $address)
    {
        $array = $address->jsonSerialize();

        $newAddress = Address::deserialize($array);

        $this->assertInstanceOf(Address::class, $newAddress);
    }

    public function testEqualsFails() {
        $address = $this->generator();
        $object = new BaseValueObject(bin2hex(random_bytes(4)));

        $this->assertTrue(!$address->equals($object));
    }

    public function testEqualsOfDifferentObjects() {
        $address = $this->generator();
        $address2 = $this->generator();

        $this->assertTrue(!$address->equals($address2));
    }

    public function testAddressToString() {
        $address = $this->generator();

        $pieces = explode(PHP_EOL, $address->__toString());

        $this->assertTrue( count($pieces) == 4);
    }
}