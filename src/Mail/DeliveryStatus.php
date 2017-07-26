<?php
namespace Infrastructure\Mail;

use Infrastructure\ValueObject\Enum\Enum;

class DeliveryStatus extends Enum
{
    const SENT = 1;
    const QUEUED = 2;
    const SCHEDULED = 3;
    const REJECTED = 4;
    const INVALID = 5;
    const UNKNOWN = 6;
}