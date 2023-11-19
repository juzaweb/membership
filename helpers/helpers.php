<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

use Juzaweb\CMS\Models\User;

if (!function_exists('is_paid_user')) {
    function is_paid_user(User $user): bool
    {
        return filter_var(has_subscription($user)?->unexpired(), FILTER_VALIDATE_BOOLEAN);
    }
}
