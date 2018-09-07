<?php

namespace ZohoSubscriptionTests\HostedPages;

use ZohoSubscription\HostedPages\Address;
use ZohoSubscriptionTests\TestCase;

class AddressTest extends TestCase
{
    /** @test */
    public function itCanCreateAnAddressEntity()
    {
        // given
        $country = 'U.S.A.';
        $state = 'CA';
        $city = 'Salt Lake City';
        $street = 'Harrington Bay Street';
        $attention = 'Benjamin George';
        $zip = '92612';

        // when
        $address = new Address();
        $address->setRegion($country, $state, $zip);
        $address->setLocale($street, $city, $attention);

        // then
        $this->assertEquals(compact('country', 'state', 'city', 'street', 'attention', 'zip'), $address->toArray());
    }
}