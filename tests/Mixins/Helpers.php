<?php

namespace ZohoSubscriptionTests\Mixins;

use ZohoSubscription\Client;
use ZohoSubscription\Contracts\Requestable;
use ZohoSubscription\Resources\Customers\Address;
use ZohoSubscription\Resources\Customers\Customer;
use ZohoSubscription\Resources\HostedPages\Subscription;
use ZohoSubscriptionTests\Fixtures\HttpClient;

trait Helpers
{
    private $httpClient;

    /**
     * @return Client
     */
    public function iHaveAClient(): Client
    {
        $client = new Client(HttpClient::class, '100100100', '$$tkn:10196==');
        $this->httpClient = $client->getHttpClientInstance();
        return $client;
    }

    /**
     * @return Customer
     */
    protected function iHaveACustomer(): Customer
    {
        $address = new Address();
        $address->setRegion('UK', 'Wearside', 'SR1 1AA');
        $address->setLocale('1 High Street', 'Sunderland', 'Jim');
        $customer = new Customer('test@example.com');
        $customer->setName('Jim', 'Jones', 'Mr.');
        $customer->setCompanyName('Jim and his Joneses');
        $customer->setCurrencyCode('DGP');
        $customer->setDisplayName('J-Dawg');
        $customer->setVatRegistration('GB', '12345678');
        $customer->setBillingAddress($address);
        $customer->setShippingAddress($address);
        return $customer;
    }

    protected function iHaveASubscription(): Subscription
    {
        return new Subscription('c-1234', 'plan-code');
    }

    protected function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    protected function assertRequestIsOnlyMadeOnce()
    {
        $this->assertEquals(1, $this->getHttpClient()->callCount());
        $this->assertCount(1, $this->getHttpClient()->getRequests());
    }

    protected function setResponse($response, $data)
    {
        $response = new $response($data);
        $this->getHttpClient()->setResponse($response);
    }

    protected function assertArrayAndJsonResponses(Requestable $item, array $response)
    {
        $this->assertArraySubset($response, $item->toArray());
        $this->assertJson(json_encode($response), $item->toJson());
    }
}