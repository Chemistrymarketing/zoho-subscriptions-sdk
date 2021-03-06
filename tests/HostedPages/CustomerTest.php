<?php

namespace ZohoSubscriptionTests\HostedPages;

use ZohoSubscription\Resources\Customers\Address;
use ZohoSubscription\Resources\Customers\Customer;
use ZohoSubscriptionTests\Mixins\Helpers;
use ZohoSubscriptionTests\TestCase;

class CustomerTest extends TestCase
{
    use Helpers;

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
        $email = 'test@example.com';
        $companyName = 'Jim and his Joneses';
        $currencyCode = 'GBP';
        $displayName = 'J-Dawg';
        $countryCode = 'GB';
        $vatNumber = '1908347562';

        // when
        $customer = new Customer($email);
        $customer->setName($firstName, $lastName, $salutation);
        $customer->setCompanyName($companyName);
        $customer->setCurrencyCode($currencyCode);
        $customer->setDisplayName($displayName);
        $customer->setVatRegistration($countryCode, $vatNumber);
        $customer->setBillingAddress($address);
        $customer->setShippingAddress($address);

        // then
        $this->assertArrayAndJsonResponses($customer, [
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
        ]);
    }


    /** @test */
    public function itCanCreateACustomerEntityWithACustomField()
    {
        // given
        $customer = new Customer('test@example.com');

        // when
        $customer->addCustomField('boom', 'bang', 'orange');

        // then
        $this->assertArrayAndJsonResponses($customer, [
            'custom_fields' => [
                [
                    'label' => 'boom',
                    'value' => 'bang',
                    'data_type' => 'orange',
                ],
            ],
        ]);
    }
    /** @test */
    public function itCanCreateACustomerEntityWithCustomFields()
    {
        // given
        $customer = new Customer('test@example.com');

        // when
        $customer->addCustomField('boom', 'bang', 'orange');
        $customer->addCustomField('roof', 'high', 'height');

        // then
        $this->assertArrayAndJsonResponses($customer, [
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
        ]);
    }

    /**
     * @test
     * @expectedException \Exception
     * @expectedExceptionMessage Trying to get ID when request not sent yet
     */
    public function itThrowsAnExceptionWhenCallingGetIdBeforeRequestIsSent()
    {
        $customer = new Customer('test@example.com');
        $customer->getId();
    }
}