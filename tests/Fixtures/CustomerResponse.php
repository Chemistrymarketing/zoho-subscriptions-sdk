<?php

namespace ZohoSubscriptionTests\Fixtures;

use Psr\Http\Message\ResponseInterface;

class CustomerResponse extends Response implements ResponseMock, ResponseInterface
{
    private $customerId;

    public function __construct($customerId)
    {
        parent::__construct();
        $this->customerId = $customerId;
    }

    public function getBody()
    {
        return json_encode([
            'customer' => [
                'customer_id' => $this->customerId,
            ],
        ]);
    }
}