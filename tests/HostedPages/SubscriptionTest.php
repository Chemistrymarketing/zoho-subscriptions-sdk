<?php

namespace ZohoSubscriptionTests\HostedPages;

use ZohoSubscription\HostedPages\Subscription;
use ZohoSubscriptionTests\TestCase;

class SubscriptionTest extends TestCase
{
    /** @test */
    public function itCanCreateASubscriptionObject()
    {
        $customerId = 'c-1234';
        $planId = 'my-plan';
        $subscription = new Subscription($customerId, $planId);

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
        $customerId = 'c-1234';
        $planId = 'my-plan';
        $redirectUrl = 'https://mysite.com/abc/123';
        $subscription = new Subscription($customerId, $planId);
        $subscription->addRedirectUrl($redirectUrl);
        $this->assertEquals([
            'customer_id' => $customerId,
            'plan' => [
                'plan_code' => $planId,
            ],
            'redirect_url' => $redirectUrl,
        ], $subscription->toArray());
    }
}