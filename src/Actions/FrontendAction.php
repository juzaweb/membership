<?php
namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Subscription\Http\Resources\PaymentHistoryResource;
use Juzaweb\Subscription\Http\Resources\PaymentMethodResource;
use Juzaweb\Subscription\Http\Resources\PlanResource;
use Juzaweb\Subscription\Models\PaymentHistory;
use Juzaweb\Subscription\Models\PaymentMethod;
use Juzaweb\Subscription\Models\Plan;

class FrontendAction extends Action
{
    public function handle(): void
    {
        $this->addAction(Action::FRONTEND_CALL_ACTION, [$this, 'enqueueStyles']);
        $this->addAction(Action::FRONTEND_INIT, [$this, 'registerProfilePages']);
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

    public function registerProfilePages(): void
    {
        $user = request()->user();

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

        $this->hookAction->registerProfilePage(
            'payment-history',
            [
               'title' => __('Payment History'),
               'contents' => 'membership::frontend.profile.payment_history',
               'data' => [
                    'paymentHistories' => fn () => PaymentHistoryResource::collection(PaymentHistory::with(['plan'])
                        ->where(['user_id' => $user->id])
                        ->paginate(10)
                    )
                        ->response()->getData(true)
                ],
            ]
        );
    }
}
