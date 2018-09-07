<?php

namespace ZohoSubscriptionTests\Fixtures;

interface ResponseMock
{
    public function setData(array $data);
    public function mergeData(array $data);
}