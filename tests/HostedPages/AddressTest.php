<?php

namespace ZohoSubscriptionTests\HostedPages;

use ZohoSubscription\Resources\Customers\Address;
use ZohoSubscriptionTests\Mixins\Helpers;
use ZohoSubscriptionTests\TestCase;

class AddressTest extends TestCase
{
    use Helpers;
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
        $this->assertArrayAndJsonResponses($address, compact(
            'country',
            'state',
            'city',
            'street',
            'attention',
            'zip'
        ));
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Address can not have an ID
     */
    public function itThrowsAnExceptionWhenITryToGetAnAddressesID()
    {
        $address = new Address();
        $address->getId();
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Request has no resource in Zoho
     */
    public function itThrowsAnExceptionWhenITryToGetAnAddressesURI()
    {
        $address = new Address();
        $address->getUri();
    }
}