<?php

namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Membership\Models\User;
use Juzaweb\Subscription\Contrasts\Subscription;
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
        $this->addFilter('frontend.view_share_user_data', [$this, 'addParamsUserResource']);

        if (plugin_enabled('juzaweb/subscription')) {
            $this->addAction(Action::INIT_ACTION, [$this, 'addMenuAdmin']);
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
                //'handler' => MembershipModuleHandler::class,
                'model' => User::class,
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
        $data['plan'] = null;

        if ($subscripted?->plan) {
            $subscripted->plan->load(['features' => fn ($q) => $q->cacheFor(3600)]);
            $data['plan'] = PlanResource::make($subscripted->plan)
                ->response()
                ->getData(true)['data'];
        }

        return $data;
    }
}
