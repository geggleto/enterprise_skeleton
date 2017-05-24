<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-09
 * Time: 11:51 PM
 */

namespace Infrastructure\ValueObject\Money;

use Money\Currency as BaseCurrency;
use Infrastructure\ValueObject\Util\Util;
use Infrastructure\ValueObject\ValueObject;

class Currency implements ValueObject
{
    /** @var BaseCurrency */
    protected $currency;

    /** @var CurrencyCode  */
    protected $code;


    public function __construct(CurrencyCode $code)
    {
        $this->code     = $code;
        $this->currency = new BaseCurrency($code->getValue());
    }

    /**
     * Tells whether two Currency are equal by comparing their names
     *
     * @param  ValueObject|Currency $currency
     * @return bool
     */
    public function equals(ValueObject $currency)
    {
        if (false === Util::classEquals($this, $currency)) {
            return false;
        }
        return $this->getCode()->getValue() == $currency->getCode()->getValue();
    }

    /**
     * Returns currency code
     *
     * @return CurrencyCode
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Returns string representation of the currency
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getCode()->getValue();
    }
}