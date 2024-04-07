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
}
