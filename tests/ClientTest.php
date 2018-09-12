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

        // when
        $client = new Client(HttpClient::class, $organisationId, $authenticationToken);

        // then
        $this->assertInstanceOf(HttpClient::class, $client->getHttpClientInstance());
        $this->assertArraySubset([
            'base_uri' => Client::API_REGION_COM,
            'headers' => [
                'Authorization' => 'Zoho-authtoken ' . $authenticationToken,
                'X-com-zoho-subscriptions-organizationid' => $organisationId,
                'Content-type' => 'application/json;charset=UTF-8',
            ],
        ], $client->getHttpClientInstance()->getConfig());
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
    /** @test */
    public function itCanSetApiRegionToEU()
    {
        // given
        $client = $this->iHaveAClient();
        // when
        $client->setApiRegionEU();
        // then
        $this->assertEquals(Client::API_REGION_EU, $client->getApiUrl());
    }

    /** @test */
    public function itCanSetApiRegionToCOM()
    {
        // given
        $client = $this->iHaveAClient();
        // when
        $client->setApiRegionCOM();
        // then
        $this->assertEquals(Client::API_REGION_COM, $client->getApiUrl());
    }

    /** @test */
    public function whenChangingApiRegionItChangesBaseClientUrl()
    {
        // given
        $client = $this->iHaveAClient();
        // when
        $client->setApiRegionEU();
        // then
        $this->assertEquals(Client::API_REGION_EU, $client->getHttpClientInstance()->getConfig('base_uri'));
        // when
        $client->setApiRegionCOM();
        // then
        $this->assertEquals(Client::API_REGION_COM, $client->getHttpClientInstance()->getConfig('base_uri'));
    }
}
