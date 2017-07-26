<?php


namespace Infrastructure\Mail;


use Infrastructure\ValueObject\Web\EmailAddress;
use Infrastructure\ValueObject\Web\Sender;

interface EmailDispatch
{
    /**
     * @param Sender $sender
     * @param EmailAddress[] $recipients
     * @param string $subject
     * @param string $body
     * @param array $attachments
     *
     * @return DispatchResponse[]
     */
    public function send(Sender $sender, array $recipients, $subject, $body, array $attachments = []);
}
