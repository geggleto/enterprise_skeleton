<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-07
 * Time: 3:54 PM
 */

namespace Infrastructure\ValueObject\Enum;

use MabeEnum\Enum as BaseEnum;
use Infrastructure\ValueObject\Util\Util;
use Infrastructure\ValueObject\ValueObject;


abstract class Enum extends BaseEnum implements ValueObject
{

    /**
     * Tells whether two Enum objects are sameValueAs by comparing their values
     *
     * @param ValueObject|Enum $enum
     *
     * @return bool
     */
    public function equals(ValueObject $enum)
    {
        if (!Util::classEquals($this, $enum)) {
            return false;
        }

        return $this->getValue() === $enum->getValue();
    }


    public function __toString()
    {
        return '';
    }
}