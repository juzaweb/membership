<?php

namespace Juzaweb\Membership\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Membership\Actions\MenuAction;

class MembershipServiceProvider extends ServiceProvider
{
    public array $bindings = [
        //
    ];

    public function boot(): void
    {
        ActionRegister::register([MenuAction::class]);
    }

    public function register()
    {
        //
    }
}
