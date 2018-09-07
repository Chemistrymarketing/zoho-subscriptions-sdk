<?php

namespace ZohoSubscriptionTests;

use GuzzleHttp\ClientInterface;
use ZohoSubscription\Client;
use ZohoSubscriptionTests\Fixtures\HttpClient;
use ZohoSubscriptionTests\Mixins\Helpers;

class ClientTest extends TestCase
{
    use Helpers;

    /** @test */
    public function itCanCreateANewClient()
    {
        $organisationId = '100100100';
        $authenticationToken = '$$tkn:10196==';
        $httpClient = new HttpClient();
        $client = new Client($httpClient, $organisationId, $authenticationToken);
        $this->assertEquals($organisationId, $client->getOrganisationId());
        $this->assertEquals($authenticationToken, $client->getAuthenticationToken());
    }

    /** @test */
    public function itCanSendACreateCustomerRequest()
    {
        $setCustomerId = '903000000000099';
        $client = $this->iHaveAClient();
        $customer = $this->iHaveACustomer();
        $this->getHttpClient()->setResponseCustomerId($setCustomerId);
        $customerId = $client->createCustomer($customer);
        $this->assertEquals(1, $this->getHttpClient()->callCount());
        $this->assertCount(1, $this->getHttpClient()->getRequests());
        $this->assertEquals($setCustomerId, $customerId);
    }

}