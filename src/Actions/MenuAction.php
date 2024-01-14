<?php

namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Membership\Support\MembershipModuleHandler;
use Juzaweb\Subscription\Contrasts\Subscription;
use Juzaweb\Subscription\Http\Datatables\SubscriptionDatatable;
use Juzaweb\Subscription\Http\Resources\PlanResource;
use Juzaweb\Subscription\Repositories\ModuleSubscriptionRepository;

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
            $this->addAction(Action::INIT_ACTION, [$this, 'addMenuAdmin']);
        }
        $this->addAction(Action::FRONTEND_INIT, [$this, 'registerMembership']);
        $this->addAction(Action::FRONTEND_CALL_ACTION, [$this, 'enqueueStyles']);
    }

    public function enqueueStyles(): void
    {
        $this->hookAction->enqueueFrontendScript(
            'subs-js',
            url('jw-styles/plugins/juzaweb/membership/js/frontend/index.js')
        );
        $this->hookAction->enqueueFrontendStyle(
            'subs-css',
            url('jw-styles/plugins/juzaweb/membership/css/frontend/index.css')
        );
    }

    public function registerMembership(): void
    {
        $this->hookAction->registerProfilePage(
            'membership',
            [
               'title' => 'Membership',
               'contents' => 'membership::frontend.index',
               'data' => [
                    'plans' => Plan::with('features')->get(),
                    'paymentMethods' => PaymentMethod::get(),
                ],
            ]
        );
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
