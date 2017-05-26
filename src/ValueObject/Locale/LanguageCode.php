<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-09
 * Time: 11:38 PM
 */

namespace Infrastructure\ValueObject\Locale;
use Infrastructure\ValueObject\Enum\Enum;

class LanguageCode extends Enum
{
    const EN = 'en_CA';
    const FR_CA = 'fr_CA';

    /**
     * @return LanguageCode
     */
    public static function EN() {
        return LanguageCode::byName('EN');
    }

    /**
     * @return LanguageCode
     */
    public static function FR() {
        return LanguageCode::byName('FR_CA');
    }

    /**
     * @return LanguageCode[]
     */
    public static function getAllLanguageCodes() {
        return [
            self::EN(),
            self::FR()
        ];
    }
}