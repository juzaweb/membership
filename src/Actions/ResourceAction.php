<?php

namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Membership\Repositories\PackageRepository;

class ResourceAction extends Action
{
    public function handle(): void
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'registerResources']);
    }
    
    public function registerResources()
    {
        $this->hookAction->addAdminMenu(
            'Membership',
            'membership',
            [
                'icon' => 'fa fa-users',
                'position' => 30,
            ]
        );
    
        $this->hookAction->registerResource(
            'packages',
            null,
            [
                'label' => 'Packages',
                'repository' => PackageRepository::class,
                'menu' => [
                    'icon' => 'fa fa-list-ul',
                    'parent' => 'membership',
                    'position' => 20,
                ],
            ]
        );
        
        $this->hookAction->registerResource(
            'payment-methods',
            null,
            [
                'label' => 'Payment Methods',
                'menu' => [
                    'icon' => 'fa fa-list-ul',
                    'parent' => 'membership',
                    'position' => 20,
                ],
            ]
        );
    }
}
