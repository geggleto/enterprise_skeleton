<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 2015-12-19
 * Time: 1:29 PM
 */

namespace Infrastructure\ValueObject\Web\Exception;

/**
 * Class InvalidURL
 *
 * @package Mobials\Model\ValueObject\Web\Exception
 */
class InvalidURL extends \Exception
{
    /**
     * @param string $url
     *
     * @return InvalidURL
     */
    public static function create($url)
    {
        return new InvalidURL("{$url} is not a valid url");
    }
}