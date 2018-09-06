<?php

namespace ZohoSubscription\HostedPages;
class Address
{
    private $attributes = [];


    public function setRegion(string $country, string $state, string $zipCode = null)
    {
        $this->attributes['country'] = $country;
        $this->attributes['state'] = $state;
        if (!is_null($zipCode)) {
            $this->attributes['zip'] = $zipCode;
        }
    }

    public function setLocale(string $street, string $city, string $attention = null)
    {
        $this->attributes['street'] = $street;
        $this->attributes['city'] = $city;
        if (!is_null($attention)) {
            $this->attributes['attention'] = $attention;
        }
    }

    public function toArray()
    {
        return $this->attributes;
    }
}