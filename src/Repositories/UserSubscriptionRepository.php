<?php

namespace Juzaweb\Membership\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Juzaweb\CMS\Repositories\BaseRepository;

/**
 * Interface UserSubscriptionRepository.
 *
 * @method \Juzaweb\Membership\Models\UserSubscription find($id, $columns = ['*']);
 */
interface UserSubscriptionRepository extends BaseRepository
{
    public function adminPaginate(int $limit, ?int $page = null, array $columns = ['*']): LengthAwarePaginator;
}
