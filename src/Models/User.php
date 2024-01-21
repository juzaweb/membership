<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Membership\Models;

use Juzaweb\CMS\Models\User as UserAlias;
use Juzaweb\Subscription\Contrasts\WithSubscriptable;
use Juzaweb\Subscription\Support\Traits\Subscriptable;

class User extends UserAlias implements WithSubscriptable
{
    use Subscriptable;

    public function getSubscriptionModuleName(): string
    {
        return $this->name;
    }
}
