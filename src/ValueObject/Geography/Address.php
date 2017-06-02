<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-08
 * Time: 11:03 AM
 */

namespace Infrastructure\ValueObject\Geography;

use Infrastructure\ValueObject\Util\Util;
use Infrastructure\ValueObject\ValueObject;

/**
 * Class Address
 *
 * @package Mobials\Model\ValueObject\Geography
 */
class Address implements ValueObject, \JsonSerializable
{
    protected $addressLine1;
    protected $addressLine2;
    protected $city;
    protected $postalCode;
    protected $country;
    protected $province;

    /**
     * @param string $addressLine1
     * @param string $addressLine2
     * @param string $city
     * @param string $postalCode
     * @param string $country
     * @param string $province
     */
    public function __construct($addressLine1, $addressLine2, $city, $postalCode, $province, $country)
    {
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->city = $city;
        $this->postalCode = strtoupper($postalCode);
        $this->country = $country;
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @return string
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param ValueObject|Address $object
     *
     * @return bool
     */
    public function equals(ValueObject $object)
    {
        if (Util::classEquals($this, $object) === false)
        {
            return false;
        }

        if (
            $object->getAddressLine1() === $this->getAddressLine1()
            && $object->getAddressLine2() === $this->getAddressLine2()
            && $object->getCity() === $this->getCity()
            && $object->getPostalCode() === $this->getPostalCode()
            && $object->getProvince() === $this->getProvince()
            && $object->getCountry() === $this->getCountry()
        )
        {
            return true;
        }

        return false;
    }

    /**
     * Returns a string representation of the Address in US standard format.
     *
     * @return string
     */
    public function __toString()
    {
        $format = <<<ADDR
%s
%s
%s %s %s
%s
ADDR;

        $addressString = \sprintf($format, $this->getAddressLine1(), $this->getAddressLine2(), $this->getCity(), $this->getProvince(), $this->getPostalCode(), $this->getCountry());
        return $addressString;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize() {
        return [
            'address_line_1' => $this->getAddressLine1(),
            'address_line_2' => $this->getAddressLine2(),
            'city' => $this->getCity(),
            'postal_code' => $this->getPostalCode(),
            'province_id' => $this->getProvince(),
            'country_code' => $this->getCountry()
        ];
    }

    /**
     * @inheritdoc
     */
    public static function deserialize(array $data) {
        return new Address(
            $data['address_line_1'],
            $data['address_line_2'],
            $data['city'],
            $data['postal_code'],
            $data['province_id'],
            $data['country_code']
        );
    }
}