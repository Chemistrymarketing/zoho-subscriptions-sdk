<?php

namespace ZohoSubscription\Contracts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Requestable
{
    public function toArray(): array;
    public function toJson(): string;
    public function getUri(): string;
    public function getRequest(): RequestInterface;
    public function setResponse(ResponseInterface $response);
    public function getId(): string;
}