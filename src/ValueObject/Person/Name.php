<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-09-29
 * Time: 12:15 AM
 */

namespace Infrastructure\ValueObject\Person;

use Infrastructure\ValueObject\ValueObject;

/**
 * Class Name
 *
 * @package Mobials\Model\ValueObject\Person
 */
class Name implements ValueObject, \JsonSerializable
{
    private $firstName;
    private $middleName;
    private $lastName;

    /**
     * Returns a Name object
     * @param string $first_name
     * @param string $middle_name
     * @param string $last_name
     */
    public function __construct($first_name, $middle_name = null, $last_name = null)
    {
        $this->firstName  = trim($first_name);
        $this->middleName = trim($middle_name);
        $this->lastName   = trim($last_name);
    }

    /**
     * Returns the first name
     *
     * @return String
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Returns the middle name
     *
     * @return String
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Returns the last name
     *
     * @return String
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        $fullNameString = $this->firstName .
                          (empty($this->middleName) ? '' : ' ' . $this->middleName) .
                          (empty($this->lastName) ? '' : ' ' . $this->lastName);
        return $fullNameString;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return \strval($this->getFullName());
    }

    /**
     * @param ValueObject|Name $object
     * @inheritdoc
     */
    public function equals(ValueObject $object)
    {
        if ($object instanceof Name === false)
        {
            return false;
        }

        if (strtolower($object->getFirstName()) === strtolower($this->getFirstName())
            && strtolower($object->getMiddleName()) === strtolower($this->getMiddleName())
            && strtolower($object->getLastName()) === strtolower($this->getLastName()))
        {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public static function deserialize(array $data)
    {
        return new Name(
            $data['first_name'],
            $data['middle_name'],
            $data['last_name']
        );
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'first_name' => $this->getFirstName(),
            'middle_name' => $this->getMiddleName(),
            'last_name' => $this->getLastName()
        ];
    }
}