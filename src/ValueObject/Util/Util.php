<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-07
 * Time: 3:56 PM
 */

namespace Infrastructure\ValueObject\Util;

/**
 * Utility class for methods used all across the library
 * @package ValueObject\Util
 */
class Util
{
    /**
     * Tells whether two objects are of the same class
     *
     * @param  object $object_a
     * @param  object $object_b
     * @return bool
     */
    public static function classEquals($object_a, $object_b)
    {
        return \get_class($object_a) === \get_class($object_b);
    }
    /**
     * Returns full namespaced class as string
     *
     * @param $object
     * @return string
     */
    public static function getClassAsString($object)
    {
        return \get_class($object);
    }
}