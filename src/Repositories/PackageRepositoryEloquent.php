<?php

namespace Juzaweb\Membership\Repositories;

use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Juzaweb\Membership\Models\Package;

/**
 * Class CommentRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class PackageRepositoryEloquent extends BaseRepositoryEloquent implements PackageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Package::class;
    }
}
