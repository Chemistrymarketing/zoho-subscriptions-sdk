<?php

namespace ZohoSubscription\Resources\Customers;

use ZohoSubscription\Contracts\Requestable;
use ZohoSubscription\Partials\HasRequestables;

class Customer implements Requestable
{
    use HasRequestables;

    public function __construct(string $email)
    {
        $this->setEmail($email);
    }

    public function setName(string $firstName, string $lastName, string $salutation = null)
    {
        $this->attributes['first_name'] = $firstName;
        $this->attributes['last_name'] = $lastName;
        if (!is_null($salutation)) {
            $this->attributes['salutation'] = $salutation;
        }
    }

    public function setDisplayName(string $value)
    {
        $this->attributes['display_name'] = $value;
    }

    public function setCompanyName(string $value)
    {
        $this->attributes['company_name'] = $value;
    }

    public function setEmail(string $value)
    {
        $this->attributes['email'] = $value;
    }

    public function setCurrencyCode(string $value)
    {
        $this->attributes['currency_code'] = $value;
    }

    public function setVatRegistration(string $countryCode, string $vatNumber)
    {
        $this->attributes['country_code'] = $countryCode;
        $this->attributes['vat_reg_no'] = $vatNumber;
    }

    public function setShippingAddress(Address $address)
    {
        $this->attributes['shipping_address'] = $address->toArray();
    }

    public function setBillingAddress(Address $address)
    {
        $this->attributes['billing_address'] = $address->toArray();
    }

    public function addCustomField(string $label, string $value, string $dataType = 'text')
    {
        if (! array_key_exists('custom_fields', $this->attributes)) {
            $this->attributes['custom_fields'] = [];
        }
        $this->attributes['custom_fields'][] = [
            'label' => $label,
            'value' => $value,
            'data_type' => $dataType,
        ];
    }

    public function getUri(): string
    {
        return 'customers';
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getId(): string
    {
        if (is_null($this->response)) {
            throw new \Exception('Trying to get ID when request not sent yet');
        }
        return json_decode($this->response->getBody())->customer->customer_id;
    }
}