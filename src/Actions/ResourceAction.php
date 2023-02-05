<?php

namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Membership\Http\Datatables\PackageDatatable;
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
                'datatable' => PackageDatatable::class,
                'menu' => [
                    'icon' => 'fa fa-list-ul',
                    'parent' => 'membership',
                    'position' => 20,
                ],
                'fields' => [
                    'name' => [
                        'label' => trans('cms::app.name'),
                    ],
                    'price' => [
                        'label' => trans('membership::content.price'),
                    ]
                ],
                'validator' => [
                    'name' => ['required', 'string', 'max:100'],
                    'price' => ['required', 'numeric', 'min:0'],
                ],
            ]
        );
        
        /*$this->hookAction->registerResource(
            'payment-methods',
            null,
            [
                'label' => 'Payment Methods',
                'menu' => [
                    'icon' => 'fa fa-cart',
                    'parent' => 'membership',
                    'position' => 20,
                ],
                'fields' => [
                    'name' => [
                        'label' => trans('cms::app.name'),
                    ],
                    'method' => [
                        'label' => trans('cms::app.method'),
                    ],
                    'configs' => [
                        'label' => trans('cms::app.config'),
                        'type' => 'repeater',
                        'fields' => [
                            'name' => [
                                'label' => trans('cms::app.name'),
                            ],
                        ]
                    ],
                ],
                'validator' => [
                    'name' => ['required', 'string', 'max:100'],
                    'method' => ['required', 'string', 'max:100'],
                ],
            ]
        );*/
    }
}
