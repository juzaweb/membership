<?php

namespace Juzaweb\Membership\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Traits\QueryCache\QueryCacheable;
use Juzaweb\CMS\Traits\ResourceModel;
use Juzaweb\CMS\Traits\UseUUIDColumn;
use Juzaweb\Network\Traits\Networkable;
use Juzaweb\Subscription\Models\PaymentMethod;
use Juzaweb\Subscription\Models\Plan;

/**
 * Juzaweb\Subscription\Models\UserSubscription
 *
 * @property int $id
 * @property string $uuid
 * @property string $agreement_id Agreement of payment partner
 * @property float $amount
 * @property string $module
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property int $method_id
 * @property int $plan_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read PaymentMethod $paymentMethod
 * @property-read Plan $plan
 * @property-read User|null $user
 * @method static Builder|UserSubscription newModelQuery()
 * @method static Builder|UserSubscription newQuery()
 * @method static Builder|UserSubscription query()
 * @method static Builder|UserSubscription whereAgreementId($value)
 * @method static Builder|UserSubscription whereAmount($value)
 * @method static Builder|UserSubscription whereCreatedAt($value)
 * @method static Builder|UserSubscription whereEndDate($value)
 * @method static Builder|UserSubscription whereFilter($params = [])
 * @method static Builder|UserSubscription whereId($value)
 * @method static Builder|UserSubscription whereMethodId($value)
 * @method static Builder|UserSubscription whereModule($value)
 * @method static Builder|UserSubscription wherePlanId($value)
 * @method static Builder|UserSubscription whereStartDate($value)
 * @method static Builder|UserSubscription whereUpdatedAt($value)
 * @method static Builder|UserSubscription whereUserId($value)
 * @method static Builder|UserSubscription whereUuid($value)
 * @method static Builder|UserSubscription isActive()
 * @mixin \Eloquent
 */
class UserSubscription extends Model
{
    use UseUUIDColumn, ResourceModel, QueryCacheable, Networkable;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_SUSPEND = 'suspend';
    public const STATUS_CANCEL = 'cancel';

    protected $table = 'membership_user_subscriptions';

    protected $fillable = [
        'module',
        'agreement_id',
        'amount',
        'method_id',
        'user_id',
        'plan_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'amount' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id', 'id');
    }

    public function scopeInEffect(Builder $query): Builder
    {
        return $query->isActive()->where('end_date', '>=', now());
    }

    public function scopeIsActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeIsFree(Builder $query): Builder
    {
        return $query->where('is_free', true);
    }

    public function scopeIsCancel(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_CANCEL);
    }

    public function scopeIsSuspend(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_SUSPEND);
    }

    public function expired(): bool
    {
        return empty($this->end_date) || $this->end_date->lt(now());
    }

    public function unexpired(): bool
    {
        return !$this->expired();
    }
}