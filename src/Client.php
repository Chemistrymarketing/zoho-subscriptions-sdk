<?php

namespace ZohoSubscription;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ZohoSubscription\HostedPages\Subscription;

class Client
{
    const API_REGION_EU = 'https://subscriptions.zoho.eu/api/v1/';
    const API_REGION_COM = 'https://subscriptions.zoho.com/api/v1/';
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
    private $httpClientInstance;
    /**
     * @var string
     */
    private $httpClientClass;
    private $apiRegion;

    public function __construct(string $client, string $organisationId, string $authenticationToken)
    {
        $this->httpClientClass = $client;
        $this->apiRegion = static::API_REGION_COM;
        $this->organisationId = $organisationId;
        $this->authenticationToken = $authenticationToken;
        $this->httpClientInstance = $this->buildClientInstance();
    }

    public static function build($id, $token)
    {
        return new static(\GuzzleHttp\Client::class, $id, $token);
    }

    private function buildClientInstance(): ClientInterface
    {
        return new $this->httpClientClass([
            'base_uri' => $this->apiRegion,
            'headers' => [
                'Authorization' => 'Zoho-authtoken ' . $this->authenticationToken,
                'X-com-zoho-subscriptions-organizationid' => $this->organisationId,
                'Content-type' => 'application/json;charset=UTF-8',
            ],
        ]);
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
        $response = $this->sendRequest(new Request('POST', 'customers', [], $customer->toJson()));
        return json_decode($response->getBody())->customer->customer_id;
    }

    public function createSubscription(Subscription $subscription): string
    {
        $response = $this->sendRequest(new Request('POST', 'hostedpages/newsubscription', [], $subscription->toJson()));
        return json_decode($response->getBody())->hostedpage->url;
    }

    private function sendRequest(RequestInterface $request): ResponseInterface
    {
         return $this->httpClientInstance->send($request, ['debug' => true]);
    }

    public function setApiRegionEU()
    {
        $this->apiRegion = static::API_REGION_EU;
        $this->httpClientInstance = $this->buildClientInstance();
    }

    public function setApiRegionCOM()
    {
        $this->apiRegion = static::API_REGION_COM;
        $this->httpClientInstance = $this->buildClientInstance();
    }

    public function getApiUrl(): string
    {
        return $this->apiRegion;
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClientInstance(): ClientInterface
    {
        return $this->httpClientInstance;
    }

}