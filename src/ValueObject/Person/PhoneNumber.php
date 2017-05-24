<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-08
 * Time: 2:32 PM
 */

namespace Infrastructure\ValueObject\Person;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use Infrastructure\ValueObject\Util\Util;
use Infrastructure\ValueObject\ValueObject;
use Infrastructure\ValueObject\Geography\CountryCode;

/**
 * Class PhoneNumber
 *
 * @package Mobials\Model\ValueObject\Person
 */
class PhoneNumber implements ValueObject, \JsonSerializable
{
    private $countryCode;
    private $nationalNumber;
    private $extension;
    private $phoneNumber;


    /**
     * @param string $phoneNumber
     * @param CountryCode $countryCode
     *
     * @throws \Exception
     */
    public function __construct($phoneNumber, CountryCode $countryCode)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try
        {
            $numberProto = $phoneUtil->parse($phoneNumber, \strval($countryCode));

            if ($phoneUtil->isValidNumber($numberProto) === false)
            {
                throw new \Exception("$phoneNumber is an invalid phone number");
            }

            $this->countryCode = $countryCode;
            $this->extension = $numberProto->getExtension();
            $this->nationalNumber = $numberProto->getNationalNumber();

            $this->phoneNumber = $phoneUtil->format($numberProto, \libphonenumber\PhoneNumberFormat::E164);

        }
        catch (NumberParseException $e)
        {
            throw new \Exception("Phone Number $phoneNumber is an invalid Phone Number");
        }
    }

    /**
     * @param ValueObject|PhoneNumber $object
     *
     * @return bool
     */
    public function equals(ValueObject $object)
    {
        if (Util::classEquals($this, $object) === false)
        {
            return false;
        }

        if ($this->getPhoneNumber() === $object->getPhoneNumber())
        {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @return CountryCode
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return null|string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getPhoneNumber();
    }

    /**
     * @return array
     */
    public function jsonSerialize() {
        return [
            'country_code' => $this->getCountryCode()->getValue(),
            'phone_number' => $this->getPhoneNumber(),
            'extension' => $this->getExtension()
        ];
    }

    public static function deserialize(array $data) {
        return new PhoneNumber($data['phone_number'], CountryCode::get($data['country_code']));
    }

}
