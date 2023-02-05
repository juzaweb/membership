<?php

namespace Juzaweb\Membership\Http\Datatables;

use Illuminate\Support\Collection;
use Juzaweb\Backend\Http\Datatables\ResourceDatatable;
use Juzaweb\CMS\Facades\HookAction;

class PackageDatatable extends ResourceDatatable
{
    public function columns(): array
    {
        return [
            'name' => [
                'label' => trans('cms::app.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ]
        ];
    }
}
