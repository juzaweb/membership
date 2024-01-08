<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Membership\Support;

use Illuminate\Support\Facades\Auth;
use Juzaweb\Membership\Models\UserSubscription;
use Juzaweb\Subscription\Contrasts\ModuleHandler;
use Juzaweb\Subscription\Contrasts\PaymentResult;
use Juzaweb\Subscription\Exceptions\PaymentException;

class MembershipModuleHandler implements ModuleHandler
{
    public function onReturn(PaymentResult $result): void
    {
        $subscriber = UserSubscription::updateOrCreate(
            [
                'user_id' => Auth::id(),
            ],
            [
                'plan_id' => $plan->id,
                'method_id' => $method->id,
                'agreement_id' => $result->getAgreementId(),
                'amount' => $result->getAmount(),
                'status' => UserSubscription::STATUS_ACTIVE,
            ]
        );
    }

    public function onWebhook(PaymentResult $result): void
    {
        $subscriber = UserSubscription::where(['agreement_id' => $result->getAgreementId()])->first();

        throw_if($subscriber === null, new PaymentException('Webhook: Not available agreement.'));

        if (empty($subscriber->user)) {
            throw new PaymentException('Webhook: Subscriber model is empty user.');
        }

        if (!$result->isActive()) {
            $subscriber->update(['status' => $result->getStatus()]);
            return;
        }

        if ($subscriber->end_date?->gt(now())) {
            $expirationDate = $subscriber->end_date->addMonth()->format('Y-m-d 23:59:59');
        } else {
            $expirationDate = now()->addMonth()->format('Y-m-d 23:59:59');
        }

        $subscriber->setAttribute('start_date', $subscriber->start_date ?? now());
        $subscriber->setAttribute('end_date', $expirationDate);
        $subscriber->save();
    }
}
