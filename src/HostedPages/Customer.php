<?php

namespace ZohoSubscription\HostedPages;
class Customer
{
    protected $attributes = [];

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

    public function toArray(): array
    {
        return $this->attributes;
    }
}