<?php
namespace Infrastructure\ValueObject\Person;
use Infrastructure\ValueObject\Exception\ContactEmailOrPhoneRequired;
use Infrastructure\ValueObject\Web\EmailAddress as Email;
use Infrastructure\ValueObject\Identity\Uuid;

/**
 * Class Contact
 *
 * @package
 */
class Contact
{
    private $name;
    private $email;
    private $phone;

    
    /**
     * @param Name $name
     * @param Email|null $email
     * @param PhoneNumber|null $phone
     * @throws \Exception
     */
    public function __construct(Name $name, Email $email = null, PhoneNumber $phone = null)
    {
        if ($email == null and $phone == null)
        {
            throw new ContactEmailOrPhoneRequired('cannot create Contact');
        }
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }
    
    /**
     * @return Name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Email|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getPhone()
    {
        return $this->phone;
    }
}