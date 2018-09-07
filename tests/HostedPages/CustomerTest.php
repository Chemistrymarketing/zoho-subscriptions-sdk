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
        // given
        $address = new Address();
        $address->setRegion('UK', 'Wearside', 'SR1 1AA');
        $address->setLocale('1 High Street', 'Sunderland', 'Jim');
        $firstName = 'Jim';
        $lastName = 'Jones';
        $salutation = 'Mr.';
        $email = 'jim@jones.com';
        $companyName = 'Jim and his Joneses';
        $currencyCode = 'GBP';
        $displayName = 'J-Dawg';
        $countryCode = 'GB';
        $vatNumber = '1908347562';

        // when
        $customer = new Customer();
        $customer->setName($firstName, $lastName, $salutation);
        $customer->setEmail($email);
        $customer->setCompanyName($companyName);
        $customer->setCurrencyCode($currencyCode);
        $customer->setDisplayName($displayName);
        $customer->setVatRegistration($countryCode, $vatNumber);
        $customer->setBillingAddress($address);
        $customer->setShippingAddress($address);

        // then
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
        // given
        $customer = new Customer();

        // when
        $customer->addCustomField('boom', 'bang', 'orange');

        // then
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
        // given
        $customer = new Customer();

        // when
        $customer->addCustomField('boom', 'bang', 'orange');
        $customer->addCustomField('roof', 'high', 'height');

        // then
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