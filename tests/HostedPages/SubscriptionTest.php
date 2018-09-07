<?php

namespace ZohoSubscriptionTests\HostedPages;

use ZohoSubscription\HostedPages\Subscription;
use ZohoSubscriptionTests\TestCase;

class SubscriptionTest extends TestCase
{
    /** @test */
    public function itCanCreateASubscriptionObject()
    {
        // given
        $customerId = 'c-1234';
        $planId = 'my-plan';

        // when
        $subscription = new Subscription($customerId, $planId);

        // then
        $this->assertEquals([
            'customer_id' => $customerId,
            'plan' => [
                'plan_code' => $planId,
            ],
        ], $subscription->toArray());
    }

    /** @test */
    public function itCanAddARedirectUrl()
    {
        // given
        $customerId = 'c-1234';
        $planId = 'my-plan';
        $redirectUrl = 'https://mysite.com/abc/123';
        // when
        $subscription = new Subscription($customerId, $planId);
        $subscription->addRedirectUrl($redirectUrl);

        // then
        $this->assertEquals([
            'customer_id' => $customerId,
            'plan' => [
                'plan_code' => $planId,
            ],
            'redirect_url' => $redirectUrl,
        ], $subscription->toArray());
    }
}