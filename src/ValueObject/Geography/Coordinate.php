<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 2016-07-23
 * Time: 11:15 AM
 */

namespace Infrastructure\ValueObject\Geography;


use Infrastructure\ValueObject\ValueObject;

/**
 * Class Coordinate
 *
 * @package Mobials\Model\ValueObject\Geography
 */
class Coordinate implements ValueObject
{
    private $latitude;
    private $longitude;

    /**
     * Coordinate constructor.
     *
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct($latitude, $longitude)
    {
        if (is_numeric($latitude) === false) {
            throw new \DomainException("Latitude must be numeric");
        }
        else if (is_numeric($longitude) === false) {
            throw new \DomainException("Longitude must be numeric");
        }

        $this->latitude = (float)$latitude;
        $this->longitude = (float)$longitude;
    }

    /**
     * @return float
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * @param Coordinate $object
     * @inheritdoc
     */
    public function equals(ValueObject $object)
    {
        return $object->getLatitude() === $this->getLatitude() && $object->getLongitude() === $this->getLongitude();
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return "{$this->getLatitude()}, {$this->getLongitude()}";
    }
}