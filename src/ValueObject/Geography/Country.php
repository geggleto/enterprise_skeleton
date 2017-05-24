<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-08
 * Time: 10:43 AM
 */

namespace Infrastructure\ValueObject\Geography;


use Infrastructure\ValueObject\Util\Util;
use Infrastructure\ValueObject\ValueObject;

//todo change how our country value object works. It should be using country code only!
class Country implements ValueObject, \JsonSerializable
{
    protected $countryCode;

    /**
     * @param $countryCode
     * @throws \Exception
     */
    public function __construct($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return CountryCode
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param ValueObject|Country $object
     *
     * @return bool
     */
    public function equals(ValueObject $object)
    {
        if (Util::classEquals($this, $object) === false)
        {
            return false;
        }

        if ($object->getCountryCode() === $this->getCountryCode())
        {
            return true;
        }
    }

    public function __toString()
    {
        return $this->getCountryCode();
    }

    function jsonSerialize()
    {
        return [
            'country_code' => $this->countryCode
        ];
    }

    public static function deserialize(array $data) {
        return new Country($data['country_code']);
    }


}