<?php

namespace ZohoSubscription;

use GuzzleHttp\ClientInterface;
use ZohoSubscription\Contracts\Requestable;

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

    public function send(Requestable $requestable): Requestable
    {
         $response = $this->httpClientInstance->send($requestable->getRequest());
         $requestable->setResponse($response);
         return $requestable;
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