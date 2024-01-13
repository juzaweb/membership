<?php

namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Membership\Repositories\UserSubscriptionRepository;
use Juzaweb\Membership\Support\MembershipModuleHandler;
use Juzaweb\Subscription\Contrasts\Subscription;
use Juzaweb\Subscription\Http\Datatables\UserSubscriptionDatatable;
use Juzaweb\Subscription\Http\Resources\PlanResource;

class MenuAction extends Action
{
    /**
     * Execute the actions.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->addFilter('user.resouce_data', [$this, 'addParamsUserResource']);

        if (plugin_enabled('juzaweb/subscription')) {
            $this->addAction(Action::BACKEND_INIT, [$this, 'addMenuAdmin']);
        }
    }

    public function addMenuAdmin(): void
    {
        $this->hookAction->addAdminMenu(
            trans('membership::content.membership'),
            'membership',
            [
                'icon' => 'fa fa-users',
                'position' => 30,
            ]
        );

        app()->make(Subscription::class)->registerModule(
            'membership',
            [
                'label' => trans('membership::content.membership'),
                'handler' => MembershipModuleHandler::class,
                'menu' => [
                    'icon' => 'fa fa-users',
                    'position' => 99,
                    'parent' => 'membership',
                ]
            ]
        );

        $this->hookAction->registerResource(
            'membership-user-subscriptions',
            null,
            [
                'label' => trans('membership::content.user_subscriptions'),
                'repository' => UserSubscriptionRepository::class,
                'datatable' => UserSubscriptionDatatable::class,
                'menu' => [
                    'icon' => 'fa fa-users',
                    'position' => 30,
                    'parent' => 'membership',
                ],
            ]
        );
    }

    public function addParamsUserResource($data)
    {
        $subscripted = has_subscription(jw_current_user(), 'membership');
        $data['is_paid'] = is_paid_user(jw_current_user(), 'membership');
        $data['plan'] = $subscripted?->plan ? PlanResource::make($subscripted->plan)
            ->response()
            ->getData() : null;
        return $data;
    }
}
