<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-09
 * Time: 11:55 PM
 */

namespace Infrastructure\ValueObject\Money;


use Infrastructure\ValueObject\ValueObject;
use Money\Money as BaseMoney;
use Money\Currency as BaseCurrency;
use Infrastructure\ValueObject\Util\Util;

class Money implements ValueObject
{
    /** @var BaseMoney */
    protected $money;

    /** @var Currency */
    protected $currency;

    /**
     * Returns a Money object
     *
     * @param int  $amount   Amount expressed in the smallest units of $currency (e.g. cents)
     * @param Currency $currency Currency of the money object
     */
    public function __construct($amount, Currency $currency)
    {
        $baseCurrency   = new BaseCurrency($currency->getCode()->getValue());
        $this->money    = new BaseMoney($amount, $baseCurrency);
        $this->currency = $currency;
    }
    /**
     *  Tells whether two Currency are equal by comparing their amount and currency
     *
     * @param  ValueObject|Money $money
     * @return bool
     */
    public function equals(ValueObject $money)
    {
        if (false === Util::classEquals($this, $money))
        {
            return false;
        }

        return $this->getAmount() === $money->getAmount() && $this->getCurrency()->equals($money->getCurrency());
    }
    /**
     * Returns money amount
     *
     * @return int
     */
    public function getAmount()
    {
        $amount = $this->money->getAmount();
        return $amount;
    }
    /**
     * Returns money currency
     *
     * @return Currency
     */
    public function getCurrency()
    {
        return clone $this->currency;
    }

    /**
     * Add an integer quantity to the amount and returns a new Money object.
     * Use a negative quantity for subtraction.
     *
     * @param  int $quantity Quantity to add
     * @return Money
     */
    public function add($quantity)
    {
        $amount = $this->getAmount() + $quantity;
        $result = new self($amount, $this->getCurrency());
        return $result;
    }


    /**
     * Returns a string representation of the Money value in format "CUR AMOUNT" (e.g.: EUR 1000)
     *
     * @return string
     */
    public function __toString()
    {
        return \sprintf('%s %d', $this->getCurrency()->getCode(), $this->getAmount());
    }
}