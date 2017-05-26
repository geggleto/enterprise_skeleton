<?php


namespace Tests\Infrastructure\ValueObject\Locale;


use Infrastructure\ValueObject\Locale\LanguageCode;
use Tests\Infrastructure\Base;

class LanguageCodeTest extends Base
{
    public function testCorrectLanguages() {
        $en = LanguageCode::EN();
        $this->assertInstanceOf(LanguageCode::class, $en);
        $this->assertEquals('en_CA', $en->getValue());

        $fr = LanguageCode::FR();
        $this->assertInstanceOf(LanguageCode::class, $fr);
        $this->assertEquals('fr_CA', $fr->getValue());
    }

    public function testAllLanguages() {

        $codes = LanguageCode::getAllLanguageCodes();

        $this->assertEquals(2, count($codes));
    }
}