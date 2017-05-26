<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-09-29
 * Time: 4:58 PM
 */

namespace Infrastructure\ValueObject\Web;

use Infrastructure\ValueObject\ValueObject;
use Infrastructure\ValueObject\Web\Exception\InvalidURL;

/**
 * Class URL
 */
class Url implements ValueObject, \JsonSerializable
{
    private $url;

    /**
     * URL constructor.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getScheme()
    {
        return parse_url($this->url, PHP_URL_SCHEME);
    }

    /**
     * @return string|null
     */
    public function getHost()
    {
        return parse_url($this->url, PHP_URL_HOST);
    }

    /**
     * @return int|null
     */
    public function getPort()
    {
        return parse_url($this->url, PHP_URL_PORT);
    }

    /**
     * @return string|null
     */
    public function getPath()
    {
        return parse_url($this->url, PHP_URL_PATH);
    }

    /**
     * @return string|null
     */
    public function getQuery()
    {
        return parse_url($this->url, PHP_URL_QUERY);
    }

    /**
     * @return string|null
     */
    public function getFragment()
    {
        return parse_url($this->url, PHP_URL_FRAGMENT);
    }

    /**
     * @param ValueObject|Url $object
     * @inheritdoc
     */
    public function equals(ValueObject $object)
    {
        if ($object instanceof Url && $this->url === $object->getURL()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return "".$this->url;
    }

    function jsonSerialize()
    {
        return [ 'url' => $this->url ];
    }

    public static function deserialize(array $data) {
        return new Url($data['url']);
    }


}