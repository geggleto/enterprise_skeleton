<?php
namespace Infrastructure\Mail;

use Infrastructure\ValueObject\Web\EmailAddress;

class DispatchResponse implements \JsonSerializable
{
    /**
     * @var EmailAddress
     */
    private $emailAddress;

    /**
     * @var DeliveryStatus
     */
    private $status;

    /**
     * @var null
     * todo decide later if we want this
     */
    private $rejectionReason;

    /**
     * @var string
     */
    private $id;

    /**
     * DispatchResponse constructor.
     *
     * @param EmailAddress $emailAddress
     * @param DeliveryStatus $status
     * @param string $id
     */
    public function __construct(EmailAddress $emailAddress, DeliveryStatus $status, $id)
    {
        $this->emailAddress = $emailAddress;
        $this->status = $status;
        $this->id = $id;
    }

    /**
     * @return EmailAddress
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @return DeliveryStatus
     */
    public function getDeliveryStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'email_address' => $this->getEmailAddress()->jsonSerialize(),
            'delivery_status' => $this->getDeliveryStatus()->getValue(),
            'id' => $this->getId()
        ];
    }


}