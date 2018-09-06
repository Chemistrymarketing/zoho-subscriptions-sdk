<?php

namespace ZohoSubscriptionTests\HostedPages;

use ZohoSubscription\HostedPages\Address;
use ZohoSubscriptionTests\TestCase;

class AddressTest extends TestCase
{
    /** @test */
    public function itCanCreateAnAddressEntity()
    {
        $country = 'U.S.A.';
        $state = 'CA';
        $city = 'Salt Lake City';
        $street = 'Harrington Bay Street';
        $attention = 'Benjamin George';
        $zip = '92612';

        $address = new Address();
        $address->setRegion($country, $state, $zip);
        $address->setLocale($street, $city, $attention);
        $this->assertEquals(compact('country', 'state', 'city', 'street', 'attention', 'zip'), $address->toArray());
    }
}