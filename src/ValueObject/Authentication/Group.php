<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-12
 * Time: 10:34 AM
 */

namespace Infrastructure\ValueObject\Authentication;

use Infrastructure\ValueObject\Util\Util;
use Infrastructure\ValueObject\ValueObject;

/**
 * Class Group
 *
 * A group is a level of authentication a user has in our system.
 *
 * @package Mobials\Model\ValueObject\Authentication
 */
class Group implements ValueObject
{
    private $group;

    public function __construct(GroupCode $group)
    {
        $this->group = $group;
    }

    public function getValue()
    {
        return $this->group;
    }

    /**
     * @param ValueObject|Group $object
     * @return boolean
     */
    public function equals(ValueObject $object)
    {
        if (Util::classEquals($this, $object) === false)
        {
            return false;
        }

        if ($object->getValue() === $this->getValue())
        {
            return true;
        }

        return false;
    }

    public function __toString()
    {
        return '';
    }
}