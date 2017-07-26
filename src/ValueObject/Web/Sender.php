<?php


namespace Infrastructure\ValueObject\Web;


class Sender
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var EmailAddress
     */
    private $emailAddress;

    /**
     * From constructor.
     *
     * @param string $name
     * @param EmailAddress $emailAddress
     */
    public function __construct($name, EmailAddress $emailAddress)
    {
        $this->name = $name;
        $this->emailAddress = $emailAddress;
    }

    /**
     * @param string $name
     * @param string $emailAddressString
     *
     * @return Sender
     */
    public static function fromStrings($name, $emailAddressString) {
        return new Sender($name, new EmailAddress($emailAddressString));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return EmailAddress
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }
}