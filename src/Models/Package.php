<?php

namespace Juzaweb\Membership\Models;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Traits\ResourceModel;

class Package extends Model
{
    use ResourceModel;
    
    protected $table = 'membership_packages';
    
    protected $fillable = [
        'name',
        'price',
    ];
    
    protected $casts = [
        'price' => 'float'
    ];
}
