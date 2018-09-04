<?php

namespace ZohoSubscriptionTests;

use ZohoSubscription\Client;

class ClientTest extends TestCase
{

    /** @test */
    public function itCanCreateANewClient()
    {
        $organisationId = '100100100';
        $authenticationToken = '$$tkn:10196==';
        $client = new Client($organisationId, $authenticationToken);
        $this->assertEquals($organisationId, $client->getOrganisationId());
        $this->assertEquals($authenticationToken, $client->getAuthenticationToken());
    }
}