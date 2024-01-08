<?php

namespace Juzaweb\Membership\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Membership\Actions\MenuAction;
use Juzaweb\Membership\Repositories\UserSubscriptionRepository;
use Juzaweb\Membership\Repositories\UserSubscriptionRepositoryEloquent;

class MembershipServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserSubscriptionRepository::class => UserSubscriptionRepositoryEloquent::class,
    ];

    public function boot(): void
    {
        ActionRegister::register([MenuAction::class]);
    }

    public function register(): void
    {
        //
    }
}
