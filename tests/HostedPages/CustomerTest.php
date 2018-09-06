<?php

namespace ZohoSubscriptionTests\HostedPages;

use ZohoSubscription\HostedPages\Address;
use ZohoSubscription\HostedPages\Customer;
use ZohoSubscriptionTests\TestCase;

class CustomerTest extends TestCase
{

    /** @test */
    public function itCanCreateACustomerEntity()
    {
        $address = new Address();
        $address->setRegion('UK', 'Wearside', 'SR1 1AA');
        $address->setLocale('1 High Street', 'Sunderland', 'Jim');
        $customer = new Customer();
        $firstName = 'Jim';
        $lastName = 'Jones';
        $salutation = 'Mr.';
        $email = 'jim@jones.com';
        $companyName = 'Jim and his Joneses';
        $currencyCode = 'GBP';
        $displayName = 'J-Dawg';
        $countryCode = 'GB';
        $vatNumber = '1908347562';
        $customer->setName($firstName, $lastName, $salutation);
        $customer->setEmail($email);
        $customer->setCompanyName($companyName);
        $customer->setCurrencyCode($currencyCode);
        $customer->setDisplayName($displayName);
        $customer->setVatRegistration($countryCode, $vatNumber);
        $customer->setBillingAddress($address);
        $customer->setShippingAddress($address);

        $this->assertEquals([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'salutation' => $salutation,
            'display_name' => $displayName,
            'company_name' => $companyName,
            'email' => $email,
            'currency_code' => $currencyCode,
            'country_code' => $countryCode,
            'vat_reg_no' => $vatNumber,
            'shipping_address' => $address->toArray(),
            'billing_address' => $address->toArray(),
        ], $customer->toArray());
    }


    /** @test */
    public function itCanCreateACustomerEntityWithACustomField()
    {
        $customer = new Customer();

        $customer->addCustomField('boom', 'bang', 'orange');
        $this->assertEquals([
            'custom_fields' => [
                [
                    'label' => 'boom',
                    'value' => 'bang',
                    'data_type' => 'orange',
                ],
            ],
        ], $customer->toArray());
    }    /** @test */
    public function itCanCreateACustomerEntityWithCustomFields()
    {
        $customer = new Customer();

        $customer->addCustomField('boom', 'bang', 'orange');
        $customer->addCustomField('roof', 'high', 'height');
        $this->assertEquals([
            'custom_fields' => [
                [
                    'label' => 'boom',
                    'value' => 'bang',
                    'data_type' => 'orange',
                ],
                [
                    'label' => 'roof',
                    'value' => 'high',
                    'data_type' => 'height',
                ],
            ],
        ], $customer->toArray());
    }
}