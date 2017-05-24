<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-09-29
 * Time: 12:32 AM
 */

namespace Infrastructure\ValueObject;


interface ValueObject
{
    /**
     * @param ValueObject $object
     *
     * @return boolean
     */
    public function equals(ValueObject $object);

    /**
     * @return string
     */
    public function __toString();
}