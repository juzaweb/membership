<?php

namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Subscription\Contrasts\Subscription;

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
    }

    public function addMenuAdmin()
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
}
