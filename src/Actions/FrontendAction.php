<?php
namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Subscription\Http\Resources\PaymentMethodResource;
use Juzaweb\Subscription\Http\Resources\PlanResource;
use Juzaweb\Subscription\Models\PaymentMethod;
use Juzaweb\Subscription\Models\Plan;

class FrontendAction extends Action
{
    public function handle(): void
    {
        $this->addAction(Action::FRONTEND_CALL_ACTION, [$this, 'enqueueStyles']);
        $this->addAction(Action::FRONTEND_INIT, [$this, 'registerMembership']);
    }

    public function enqueueStyles(): void
    {
        $this->hookAction->enqueueFrontendScript(
            'subs-js',
            plugin_asset('js/frontend/pricing.min.js', 'juzaweb/membership')
        );
        $this->hookAction->enqueueFrontendStyle(
            'subs-css',
            plugin_asset('css/frontend/pricing.min.css', 'juzaweb/membership')
        );
    }

    public function registerMembership(): void
    {
        $this->hookAction->registerProfilePage(
            'membership',
            [
               'title' => __('Upgrade'),
               'contents' => 'membership::frontend.profile.upgrade',
               'data' => [
                    'plans' => fn () => PlanResource::collection(Plan::with(['features'])
                        ->whereIsActive()
                        ->where(['module' => 'membership'])
                        ->get()
                    )
                        ->toArray([])
                    ,
                    'paymentMethods' => fn () => PaymentMethodResource::collection(
                        PaymentMethod::where(['module' => 'membership'])->get()
                    )
                        ->toArray([]),
                ],
            ]
        );
    }
}
