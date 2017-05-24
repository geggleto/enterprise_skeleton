<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-09-29
 * Time: 12:16 AM
 */

namespace Infrastructure\ValueObject;
use Infrastructure\ValueObject\Exception\InvalidArgumentException;

class StringLiteral implements ValueObject
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        if (\is_string($value) === false)
        {
            throw new InvalidArgumentException();
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getString()
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->value;
    }


    /**
     * Tells whether the StringLiteral is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return \strlen($this->getString()) == 0;
    }

    /**
     * @inheritdoc
     */
    public function equals(ValueObject $object)
    {
        if ($object instanceof StringLiteral)
        {
            return false;
        }

        if ($this->getString() === $object->getString())
        {
            return true;
        }

        return false;
    }
}