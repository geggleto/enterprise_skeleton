<?php


namespace Tests\Infrastructure\ValueObject\Web;


use Infrastructure\ValueObject\Locale\LanguageCode;
use Infrastructure\ValueObject\Web\EmailAddress;
use Tests\Infrastructure\Base;

class EmailAddressTest extends Base
{
    public function testConstruction() {
        $faker = \Faker\Factory::create();
        $addr = $faker->email;
        $email = new EmailAddress($addr);

        $this->assertEquals($addr, $email->getEmail());
        $this->assertEquals($addr, $email->__toString());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConstruction() {
        $email = new EmailAddress("");
    }

    public function testSerialization() {
        $faker = \Faker\Factory::create();
        $email = new EmailAddress($faker->email);

        $array = $email->jsonSerialize();

        $newEmail = EmailAddress::deserialization($array);

        $this->assertTrue($email->equals($newEmail));
    }

    public function testNotEqual() {
        $faker = \Faker\Factory::create();
        $email = new EmailAddress($faker->email);

        $this->assertTrue(!$email->equals(LanguageCode::EN()));
    }
}