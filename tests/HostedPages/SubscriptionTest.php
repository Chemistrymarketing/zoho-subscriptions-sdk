<?php

namespace ZohoSubscriptionTests\HostedPages;

use ZohoSubscription\HostedPages\Subscription;
use ZohoSubscriptionTests\TestCase;

class SubscriptionTest extends TestCase
{
    /** @test */
    public function itCanCreateASubscriptionObject()
    {
        $subscription = new Subscription();

        $this->assertEquals([], $subscription->toArray());
    }
}