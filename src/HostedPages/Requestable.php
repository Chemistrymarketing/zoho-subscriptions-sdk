<?php

namespace ZohoSubscription\HostedPages;

interface Requestable
{
    public function toArray(): array;
    public function toJson(): string;
}