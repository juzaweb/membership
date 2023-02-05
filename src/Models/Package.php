<?php

namespace Juzaweb\Membership\Models;

use Juzaweb\CMS\Models\Model;

class Package extends Model
{
    protected $table = 'membership_packages';
    
    protected $fillable = [
        'name',
        'price',
    ];
    
    protected $casts = [
        'price' => 'float'
    ];
}
