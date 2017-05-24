<?php
/**
 * Created by PhpStorm.
 * User: bradleyhanebury
 * Date: 15-10-12
 * Time: 10:36 AM
 */

namespace Infrastructure\ValueObject\Authentication;

use Infrastructure\ValueObject\Enum\Enum;

class GroupCode extends Enum
{
    const USER = 1;
    const STAFF = 10;
    const ADMIN = 50;
    const ENTERPRISE = 75;
    const SUPERADMIN = 100;
}