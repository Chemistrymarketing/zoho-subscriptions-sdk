<?php

namespace ZohoSubscriptionTests;

use ZohoSubscription\Client;
use ZohoSubscriptionTests\Fixtures\CustomerResponse;
use ZohoSubscriptionTests\Fixtures\HttpClient;
use ZohoSubscriptionTests\Fixtures\SubscriptionResponse;
use ZohoSubscriptionTests\Mixins\Helpers;

class ClientTest extends TestCase
{
    use Helpers;

    /** @test */
    public function itCanCreateANewClient()
    {
        // given
        $organisationId = '100100100';
        $authenticationToken = '$$tkn:10196==';
        $httpClient = new HttpClient();

        // when
        $client = new Client($httpClient, $organisationId, $authenticationToken);

        // then
        $this->assertEquals($organisationId, $client->getOrganisationId());
        $this->assertEquals($authenticationToken, $client->getAuthenticationToken());
    }

    /** @test */
    public function itCanSendACreateCustomerRequest()
    {
        // given
        $client = $this->iHaveAClient();
        $customer = $this->iHaveACustomer();
        $customerId = '903000000000099';
        $this->setResponse(CustomerResponse::class, $customerId);

        // when
        $responseCustomerId = $client->createCustomer($customer);

        //then
        $this->assertRequestIsOnlyMadeOnce();
        $this->assertEquals($customerId, $responseCustomerId);
    }

    /** @test */
    public function itCanSendASubscriptionRequest()
    {
        // given
        $client = $this->iHaveAClient();
        $subscription = $this->iHaveASubscription();
        $url = 'http://my.site/checkout';
        $this->setResponse(SubscriptionResponse::class, $url);

        // when
        $responseUrl = $client->createSubscription($subscription);

        // then
        $this->assertRequestIsOnlyMadeOnce();
        $this->assertEquals($url, $responseUrl);
    }
}
