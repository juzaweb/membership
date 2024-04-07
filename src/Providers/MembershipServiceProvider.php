<?php

namespace Juzaweb\Membership\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Membership\Actions\FrontendAction;
use Juzaweb\Membership\Actions\MenuAction;
use Juzaweb\Membership\Actions\SubscriptionFeatureAction;

class MembershipServiceProvider extends ServiceProvider
{
    public array $bindings = [
        //
    ];

    public function boot(): void
    {
        ActionRegister::register([
            MenuAction::class,
            FrontendAction::class,
            SubscriptionFeatureAction::class,
        ]);
    }

    public function register(): void
    {
        //
    }
}
