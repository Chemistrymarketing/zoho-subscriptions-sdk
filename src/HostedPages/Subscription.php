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

    public function getUri(): string
    {
        return 'hostedpages/newsubscription';
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
        return json_decode($this->response->getBody())->hostedpage->url;
    }
}