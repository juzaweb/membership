<?php

namespace Juzaweb\Membership\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Membership\Actions\ResourceAction;
use Juzaweb\Membership\Repositories\PackageRepository;
use Juzaweb\Membership\Repositories\PackageRepositoryEloquent;

class MembershipServiceProvider extends ServiceProvider
{
    public array $bindings = [
        PackageRepository::class => PackageRepositoryEloquent::class,
    ];
    
    public function boot()
    {
        ActionRegister::register([ResourceAction::class]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
