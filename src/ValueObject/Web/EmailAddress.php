<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-09-29
 * Time: 12:22 AM
 */

namespace Infrastructure\ValueObject\Web;
use Infrastructure\ValueObject\Exception\InvalidArgumentException;
use Infrastructure\ValueObject\ValueObject;

/**
 * Class EmailAddress
 *
 * @package Mobials\Model\ValueObject\Web
 */
final class EmailAddress implements ValueObject, \JsonSerializable
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param $email
     */
    public function __construct($email)
    {
        if ( filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            throw new InvalidArgumentException('Email is invalid. ' . $email);
        }

        $this->email = $email;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getEmail();
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function equals(ValueObject $object)
    {
        if ($object instanceof EmailAddress && $object->getEmail() == $this->getEmail())
        {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    function jsonSerialize()
    {
        return [
            'email' => $this->email
        ];
    }

    public static function deserialization(array $data) {
        return new EmailAddress($data['email']);
    }

}