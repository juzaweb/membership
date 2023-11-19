<?php

namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Subscription\Contrasts\Subscription;
use Juzaweb\Subscription\Http\Resources\PlanResource;

class MenuAction extends Action
{
    public function __construct(protected Subscription $subscription)
    {
        parent::__construct();
    }

    /**
     * Execute the actions.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addMenuAdmin']);
        $this->addFilter('user.resouce_data', [$this, 'addParamsUserResource']);
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

        $this->subscription->registerModule(
            'membership',
            [
                'label' => trans('membership::content.membership'),
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
        $subscripted = has_subscription(jw_current_user());
        $data['is_paid'] = is_paid_user(jw_current_user());
        $data['plan'] = $subscripted?->plan ? PlanResource::make($subscripted->plan)
            ->response()
            ->getData() : null;
        return $data;
    }
}
