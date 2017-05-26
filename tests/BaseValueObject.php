<?php


namespace Tests\Infrastructure;


use Infrastructure\ValueObject\ValueObject;

class BaseValueObject implements ValueObject
{
    protected $value;

    public function __construct($value = '')
    {
        $this->value = $value;
    }

    public function equals(ValueObject $object)
    {
        return ($this->value === $object->__toString());
    }

    public function __toString()
    {
        return $this->value;
    }

}