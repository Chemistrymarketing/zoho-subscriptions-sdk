<?php

namespace ZohoSubscription;
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

    public function __construct(string $organisationId, string $authenticationToken)
    {

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
}