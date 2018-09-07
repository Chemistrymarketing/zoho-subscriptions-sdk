<?php

namespace ZohoSubscription;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\StreamWrapper;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /**
     * @var string
     */
    private $organisationId;
    /**
     * @var string
     */
    private $authenticationToken;
    /**
     * @var ClientInterface
     */
    private $httpClient;

    public function __construct(ClientInterface $client, string $organisationId, string $authenticationToken)
    {
        $this->httpClient = $client;

        $this->organisationId = $organisationId;
        $this->authenticationToken = $authenticationToken;
    }

    /**
     * @return string
     */
    public function getOrganisationId(): string
    {
        return $this->organisationId;
    }

    public function getAuthenticationToken(): string
    {
        return $this->authenticationToken;
    }

    /**
     * @param HostedPages\Customer $customer
     * @return string   Customer ID
     */
    public function createCustomer(HostedPages\Customer $customer): string
    {
        $response = $this->sendRequest('POST', 'https://subscriptions.zoho.com/api/v1/customers', [
            'body' => json_encode($customer->toArray()),
        ]);
        return json_decode($response->getBody())->customer->customer_id;
    }

    private function sendRequest($method, $uri, $options): ResponseInterface
    {
        return $this->httpClient->send(new Request($method, $uri, $options), [
            'Authorization' => 'Zoho-authtoken ' . $this->authenticationToken,
            'X-com-zoho-subscriptions-organizationid' => $this->organisationId,
            'Content-type' => 'application/json;charset=UTF-8'
        ]);
    }
}