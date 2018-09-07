<?php

namespace ZohoSubscriptionTests\Mixins;

use ZohoSubscription\Client;
use ZohoSubscription\HostedPages\Address;
use ZohoSubscription\HostedPages\Customer;
use ZohoSubscriptionTests\Fixtures\HttpClient;

trait Helpers
{
    private $httpClient;
    /**
     * @return Client
     */
    public function iHaveAClient(): Client
    {
        $this->httpClient = new HttpClient();
        $client = new Client($this->httpClient, '100100100', '$$tkn:10196==');
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
        $customer = new Customer();
        $customer->setName('Jim', 'Jones', 'Mr.');
        $customer->setEmail('jim@jones.com');
        $customer->setCompanyName('Jim and his Joneses');
        $customer->setCurrencyCode('DGP');
        $customer->setDisplayName('J-Dawg');
        $customer->setVatRegistration('GB', '12345678');
        $customer->setBillingAddress($address);
        $customer->setShippingAddress($address);
        return $customer;
    }

    protected function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }
}