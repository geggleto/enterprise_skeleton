<?php


namespace Tests\Infrastructure\ValueObject\Person;


use Infrastructure\ValueObject\Locale\LanguageCode;
use Infrastructure\ValueObject\Person\Name;
use Tests\Infrastructure\Base;

class NameTest extends Base
{
    public function testSanity()
    {
        $faker = \Faker\Factory::create();

        $fname = $faker->firstName;
        $mname = $faker->name;
        $lname = $faker->lastName;

        $name = new Name(
            $fname, $mname, $lname
        );

        $this->assertEquals($fname, $name->getFirstName());
        $this->assertEquals($mname, $name->getMiddleName());
        $this->assertEquals($lname, $name->getLastName());
        $this->assertEquals("$fname $mname $lname", $name->getFullName());

        $this->assertEquals("$fname $mname $lname", $name->__toString());

        return $name;
    }

    /**
     * @param Name $name
     *
     * @depends testSanity
     */
    public function testSerialization(Name $name)
    {
        $array = $name->jsonSerialize();
        $name2 = Name::deserialize($array);

        $this->assertTrue($name->equals($name2));
    }

    public function testEquals() {
        $faker = \Faker\Factory::create();

        $fname = $faker->firstName;
        $mname = $faker->name;
        $lname = $faker->lastName;

        $name = new Name(
            $fname, $mname, $lname
        );

        $fname = $faker->firstName;
        $mname = $faker->name;
        $lname = $faker->lastName;

        $name2 = new Name(
            $fname, $mname, $lname
        );

        $this->assertTrue(!$name2->equals($name));

        $this->assertTrue(!$name2->equals(LanguageCode::EN()));
    }
}