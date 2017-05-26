<?php


namespace Tests\Infrastructure\ValueObject\Enum;

use Tests\Infrastructure\Base;
use Tests\Infrastructure\BaseEnum;
use Tests\Infrastructure\BaseEnum2;

class EnumTest extends Base
{
    public function testToString()
    {
        $enum = BaseEnum::byName('TESTING_IS_AWESOME');
        $this->assertEquals('', $enum->__toString());
    }

    public function testEquals()
    {
        $enum = BaseEnum::byName('TESTING_IS_AWESOME');
        $enum2 = BaseEnum::byName('TESTING_IS_AWESOME');

        $this->assertTrue($enum->equals($enum2));
    }

    public function testEqualsWhenComparingDifferentEnums()
    {
        $enum = BaseEnum::byName('TESTING_IS_AWESOME');
        $enum2 = BaseEnum2::byName('TESTING_IS_AWESOME');

        $this->assertTrue(!$enum->equals($enum2));
    }
}