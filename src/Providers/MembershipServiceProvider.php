<?php

namespace Juzaweb\Modules\Membership\Providers;

use Juzaweb\Core\Facades\Menu;
use Juzaweb\Core\Providers\ServiceProvider;
use Juzaweb\Modules\Membership\Services\MembershipSubscription;
use Juzaweb\Modules\Subscription\Contracts\Subscription;

class MembershipServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app[Subscription::class]->registerModule(
            'membership',
            function () {
                return new MembershipSubscription();
            }
        );

        $this->booted(function () {
            $this->registerMenus();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/membership.php' => config_path('membership.php'),
        ], 'config');
        $this->mergeConfigFrom(__DIR__ . '/../../config/membership.php', 'membership');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'membership');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang', 'membership');
    }

    /**
     * Register views.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/membership');

        $sourcePath = __DIR__ . '/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'membership-module-views']);

        $this->loadViewsFrom($sourcePath, 'membership');
    }

    protected function registerMenus()
    {
        Menu::make('subscription-methods', __('Subscription Methods'))
            ->parent('settings');
    }
}
