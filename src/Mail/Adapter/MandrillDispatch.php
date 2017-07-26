<?php
namespace Infrastructure\Mail\Adapter;


use Infrastructure\Events\EventDispatcher;
use Infrastructure\Mail\DeliveryStatus;
use Infrastructure\Mail\DispatchResponse;
use Infrastructure\Mail\EmailDispatch;
use Infrastructure\Mail\EmailWasSent;
use Infrastructure\ValueObject\Web\EmailAddress;
use Infrastructure\ValueObject\Web\Sender;

class MandrillDispatch implements EmailDispatch
{
    /**
     * @var \Mandrill
     */
    private $mandrill;

    /** @var  EventDispatcher */
    private $dispatcher;

    /**
     * MandrillEmailDispatch constructor.
     *
     * @param \Mandrill $mandrill
     * @param EventDispatcher $dispatcher
     */
    public function __construct(\Mandrill $mandrill, EventDispatcher $dispatcher)
    {
        $this->mandrill = $mandrill;
        $this->dispatcher = $dispatcher;
    }

    public function send(Sender $sender, array $recipients, $subject, $body, array $attachments = [])
    {
        try {
            $to = array_map(function (EmailAddress $recipient) {
                return [
                    'email' => $recipient->getEmail(),
                    'type' => 'to'
                ];
            }, $recipients);


            $message = [
                'html' => $body,
                'subject' => $subject,
                'from_email' => $sender->getEmailAddress()->getEmail(),
                'from_name' => $sender->getName(),
                'to' => $to
            ];

            if (!empty($attachments)) {
                $message['attachments'] = $attachments;
            }

            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = null;
            $responses = $this->mandrill->messages->send($message, $async, $ip_pool, $send_at);

            $this->dispatcher->dispatch(new EmailWasSent($message));
        } catch (\Exception $exception) {
            //Mandrill API Error
            return [];
        }


        return array_map(function($response) {

            switch ($response['status']) {
                case 'sent':
                    $status = DeliveryStatus::byName('SENT');
                    break;
                case 'queued':
                    $status = DeliveryStatus::byName('QUEUED');
                    break;
                case 'scheduled':
                    $status = DeliveryStatus::byName('SCHEDULED');
                    break;
                case 'rejected':
                    $status = DeliveryStatus::byName('REJECTED');
                    break;
                case 'invalid':
                    $status = DeliveryStatus::byName('INVALID');
                    break;
                default:
                    $status = DeliveryStatus::byName('UNKNOWN');
            }

            return new DispatchResponse(new EmailAddress($response['email']), $status, $response['_id']);
        }, $responses);
    }
}