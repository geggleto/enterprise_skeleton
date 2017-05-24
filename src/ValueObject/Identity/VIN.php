<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-27
 * Time: 11:54 AM
 */

namespace Infrastructure\ValueObject\Identity;

use Infrastructure\ValueObject\ValueObject;
use Infrastructure\ValueObject\Util\Util;

/**
 * Class VIN
 *
 * A VIN represents a vehicle identity. From a VIN, we can use a decoder to access
 * the year, make, model, and trim.
 *
 * @package Mobials\Model\ValueObject\Identity
 */
class VIN implements ValueObject
{
    private $vin;

    /**
     * @param string $vin
     * @throws \Exception
     */
    public function __construct($vin)
    {
        if (strlen($vin) !== 17)
        {
            throw new \Exception("VIN must be least 17 characters in length");
        }

        $this->vin = strtoupper($vin);
    }

    /**
     * @return string
     */
    public function getVIN()
    {
        return $this->vin;
    }

    /**
     * @param ValueObject|VIN $object
     * @inheritdoc
     */
    public function equals(ValueObject $object)
    {
        if (Util::classEquals($this, $object) === false)
        {
            return false;
        }

        return $object->getVIN() === $this->getVIN();
    }

    /**
     * @return string
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getVIN();
    }
}