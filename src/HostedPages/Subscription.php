<?php

namespace ZohoSubscription\HostedPages;

class Subscription implements Requestable
{
    use HasRequestables;

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

}