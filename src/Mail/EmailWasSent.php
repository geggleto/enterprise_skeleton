<?php


namespace Infrastructure\Mail;


use Infrastructure\Events\DomainEvent;

class EmailWasSent implements DomainEvent
{
    const ROUTING_KEY = 'infrastructure.email_was_sent';

    /**
     * Standard key/values are:
     * - html: string the HTML body of the email
     * - text: string the text body of the email
     * - headers: an array of email headers. E.g., ['Content-Type' => 'text/xml']
     * - subject: string
     * - from_email: string
     * - from_name: string
     * - to: string
     * - attachments: an array of base64 encoded attachments. E.g., ['type' => 'text/json', 'name' => 'file.json', 'content' => 'base64encoded-content-here']
     *
     * @var array
     */
    protected $payload = [];

    /**
     * EmailWasSent constructor.
     *
     * @param array $payload
     */
    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    /**
     * @inheritdoc
     */
    public static function deserialize(array $body)
    {
        return new self($body['payload']);
    }

    /**
     * @inheritdoc
     */
    public function getEventName()
    {
        return self::ROUTING_KEY;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return ['payload' => $this->payload];
    }

    public function getPayload() {
        return $this->payload;
    }
}