<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-09-29
 * Time: 12:12 AM
 */

namespace Infrastructure\ValueObject\Web;
use Infrastructure\ValueObject\Locale\LanguageCode;
use Infrastructure\ValueObject\Person\Name;
use Infrastructure\ValueObject\ValueObject;

/**
 * Class EmailContact
 * This class is useful when you need to compile a list of email contacts as recipients or senders in an email
 *
 * @package Mobials\Model\ValueObject\Web
 */
final class EmailContact implements ValueObject, \JsonSerializable
{
    /**
     * @var Name
     */
    private $name;

    /**
     * @var EmailAddress
     */
    private $email;

    /**
     * @var LanguageCode
     */
    private $languageCode;

    /**
     * @param Name $name
     * @param EmailAddress $email
     * @param LanguageCode $languageCode
     */
    public function __construct(Name $name, EmailAddress $email, LanguageCode $languageCode = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->languageCode = empty($languageCode) ? LanguageCode::getByName('EN') : $languageCode;
    }

    /**
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string|null $middleName
     * @param string|null $languageCode
     *
     * @return EmailContact
     * @throws \InvalidArgumentException
     */
    public static function fromString($email, $firstName, $lastName = null, $middleName = null, $languageCode = 'en') {

        $languageCode = !empty($languageCode) ? LanguageCode::get($languageCode) : LanguageCode::get('en');

        return new EmailContact(
            new Name($firstName, $middleName, $lastName),
            new EmailAddress($email),
            $languageCode
        );
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return EmailAddress
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return LanguageCode
     */
    public function getLanguageCode() {
        return $this->languageCode;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->name->getFullName() . ' <' . $this->email . '>';
    }

    /**
     * @inheritdoc
     * @param ValueObject|EmailContact $object
     */
    public function equals(ValueObject $object)
    {
        if ($object instanceof EmailContact === false)
        {
            return false;
        }

        if ($this->getName()->equals($object->getName())
        && $this->getEmail()->equals($object->getEmail())
        && $this->getLanguageCode()->equals($object->getLanguageCode()))
        {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'email_address' => $this->getEmail()->getEmail(),
            'name' => [
                'first_name' => $this->getName()->getFirstName(),
                'middle_name' => $this->getName()->getMiddleName(),
                'last_name' => $this->getName()->getLastName(),
            ],
            'language_code' => $this->getLanguageCode() ? $this->getLanguageCode()->getValue() : null
        ];
    }
}