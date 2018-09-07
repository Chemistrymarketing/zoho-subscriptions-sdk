<?php

namespace ZohoSubscription\HostedPages;

class Subscription
{
    private $attributes = [];
    public function __construct($customerId, $planCode)
    {
        $this->attributes = [
            'customer_id' => $customerId,
            'plan' => [
                'plan_code' => $planCode,
            ]
        ];
    }

    public function addRedirectUrl(string $redirectUrl)
    {
        $this->attributes['redirect_url'] = $redirectUrl;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }
}