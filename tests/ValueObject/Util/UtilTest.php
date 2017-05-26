<?php
namespace Tests\Infrastructure\ValueObject\Util;


use Infrastructure\ValueObject\Locale\LanguageCode;
use Infrastructure\ValueObject\Util\Util;
use Tests\Infrastructure\Base;

class UtilTest extends Base
{
    public function testGetClass() {
        $class = Util::getClassAsString(LanguageCode::EN());

        $this->assertEquals(LanguageCode::class, $class);
    }
}