<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-14
 * Time: 3:26 PM
 */

namespace Infrastructure\ValueObject\Geography;
use Infrastructure\ValueObject\Enum\Enum;
use Infrastructure\ValueObject\Util\Util;
use Infrastructure\ValueObject\ValueObject;

class ProvinceCode implements ValueObject, \JsonSerializable
{
    public static $codes = [
        'USA' => [

        ],
        'CA' => [
            'ON',
            'AB',
            'PE',
            'NF',
            'NS',
            'NB',
            'QC',
            'MB',
            'SK',
            'BC',
            'YT',
            'NT',
            'NU'
        ]
    ];

    protected $countryCode;
    protected $provinceCode;

    public function __construct(CountryCode $countryCode, $provinceCode)
    {
        $this->countryCode = $countryCode;
        $this->provinceCode = $provinceCode;
    }

    /**
     * Fetch a province ID based on a country code and province code (string)
     *
     * @param CountryCode $countryCode
     * @param $provinceCode
     *
     * @return ProvinceCode
     * @throws \Exception
     */
    public static function fromCountryAndProvinceCode(CountryCode $countryCode, $provinceCode)
    {
        if ( ! isset(self::$codes[$countryCode->getValue()]) )
        {
            throw new \Exception("Invalid Country {$countryCode->getValue()}");
        }

        if (!in_array($provinceCode, self::$codes[$countryCode->getValue()])) {
            throw new \Exception("Invalid Province {$provinceCode} for Country {$countryCode->getValue()}");
        }

        return new self($countryCode, $provinceCode);
    }

    /**
     * @param $provinceCode
     *
     * @return ProvinceCode
     */
    public static function forCanada($provinceCode) {
        return self::fromCountryAndProvinceCode(CountryCode::get('CA'), $provinceCode);
    }

    public function getProvinceCode() {
        return $this->provinceCode;
    }

    /**
     * @inheritDoc
     */
    public function equals(ValueObject $object)
    {
        if (Util::classEquals($this, $object) === false)
        {
            return false;
        }

        /** @var $object self */

        if (
            $object->getProvinceCode() === $this->getProvinceCode() &&
            $object->getCountryCode()->equals($this->getCountryCode())
        )
        {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->provinceCode;
    }

    /**
     * @return CountryCode
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public static function deserialize(array $data) {
        return new ProvinceCode(CountryCode::get($data['country_code']), $data['province_code']);
    }

    function jsonSerialize()
    {
        return [
            'country_code' => $this->countryCode->getValue(),
            'province_code' => $this->provinceCode
        ];
    }


}