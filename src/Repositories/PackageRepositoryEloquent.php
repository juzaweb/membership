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
    public function adminPaginate(int $limit, int $page = null, $columns = ['*']): mixed
    {
        $this->applyCriteria();
        $this->applyScope();
        $results = $this->model->paginate($limit, $columns, 'page', $page);
        $results->appends(app('request')->query());
        $this->resetModel();
    
        return $this->parserResult($results);
    }
    
    public function model(): string
    {
        return Package::class;
    }
}
