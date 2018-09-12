<?php

namespace ZohoSubscriptionTests\Fixtures;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements ClientInterface
{
    private $calls = 0;
    private $requests = [];
    /** @var ResponseInterface */
    private $response;
    private $customerId;
    private $options;

    public function callCount(): int
    {
        return $this->calls;
    }

    public function getRequests(): array
    {
        return $this->requests;
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function __construct($options = [])
    {
        $this->options = $options;
    }

    public function send(RequestInterface $request, array $options = [])
    {
        $this->calls++;
        $this->requests[] = $request;
        return $this->response;
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
    }

    public function request($method, $uri, array $options = [])
    {
    }

    public function requestAsync($method, $uri, array $options = [])
    {
    }

    public function getConfig($option = null)
    {
        if (!is_null($option)) {
            return $this->options[$option];
        }
        return $this->options;
    }
}