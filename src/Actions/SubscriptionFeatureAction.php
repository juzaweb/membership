<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Membership\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Subscription\Contrasts\Subscription;

class SubscriptionFeatureAction extends Action
{
    public function handle(): void
    {
        if (plugin_enabled('juzaweb/ads-manager')) {
            $this->addAction(Action::INIT_ACTION, [$this, 'registerSubscriptionFeatures']);

            $this->addFilter('jwad.can_show_ads', [$this, 'filterCanShowAds']);
        }
    }

    public function registerSubscriptionFeatures(): void
    {
        app()->make(Subscription::class)->registerPlanFeature(
            'view_ads',
            [
                'label' => __('No Ads on website'),
                'module' => 'membership',
            ]
        );
    }

    public function filterCanShowAds($canShowAds): bool
    {
        $user = request()?->user();

        if (!$user) {
            return $canShowAds;
        }

        $plan = subscripted_plan($user, 'membership');

        if (!$plan) {
            return $canShowAds;
        }

        $planFeature = $plan->features()
            ->where(['feature_key' => 'view_ads'])
            ->first();

        if (!$planFeature || $planFeature->value != 1) {
            return $canShowAds;
        }

        return false;
    }
}
