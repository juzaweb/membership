<?php

namespace Juzaweb\Membership\Http\Controllers;

use Juzaweb\CMS\Http\Controllers\BackendController;

class MembershipController extends BackendController
{
    public function index()
    {
        //

        return view('jume::index', [
            'title' => 'Title Page',
        ]);
    }
}
