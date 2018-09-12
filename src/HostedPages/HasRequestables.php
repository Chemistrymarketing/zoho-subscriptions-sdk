<?php

namespace ZohoSubscription\HostedPages;

trait HasRequestables
{
    private $attributes = [];


    public function toArray(): array
    {
        return $this->attributes;
    }

    public function toJson(): string
    {
        return json_encode($this->attributes);
    }
}