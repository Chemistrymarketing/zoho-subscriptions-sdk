<?php

namespace ZohoSubscription\HostedPages;

class Address implements Requestable
{
    use HasRequestables;

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

    /**
     * @return string
     * @throws \Exception
     */
    public function getUri(): string
    {
        throw new \Exception('Request has no resource in Zoho');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getId(): string
    {
        throw new \Exception('Address can not have an ID');
    }
}