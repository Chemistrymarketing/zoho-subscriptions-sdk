<?php

namespace ZohoSubscription\Partials;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

trait HasRequestables
{
    private $attributes = [];
    private $response;


    public function toArray(): array
    {
        return $this->attributes;
    }

    public function toJson(): string
    {
        return json_encode($this->attributes);
    }

    public function getRequest(): RequestInterface
    {
        return new Request('POST', $this->getUri(), [], $this->toJson());
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

}