<?php

namespace ZohoSubscriptionTests\Fixtures;

class SubscriptionResponse extends Response implements ResponseMock
{
    private $pageUrl;

    public function __construct($pageUrl)
    {
        parent::__construct();
        $this->pageUrl = $pageUrl;
    }

    public function getBody()
    {
        return json_encode([
            'hostedpage' => [
                'url' => $this->pageUrl,
            ],
        ]);
    }
}