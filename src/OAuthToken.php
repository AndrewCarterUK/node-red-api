<?php

namespace NodeRED;

class OAuthToken implements \Serializable
{
    private $accessToken;
    private $expiryTime;
    private $tokenType;

    public function __construct($accessToken, $expirySeconds, $tokenType)
    {
        $this->accessToken = $accessToken;
        $this->expiryTime = time() + $expirySeconds;
        $this->tokenType = $tokenType;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function hasExpired()
    {
        return time() > $this->expiryTime;
    }

    public function getTokenType()
    {
        return $this->tokenType;
    }

    public function getAuthorizationString()
    {
        return $this->getTokenType() . ' ' . $this->getAccessToken();
    }

    public function serialize()
    {
        $collected = [$this->accessToken, $this->expiryTime, $this->tokenType];

        return serialize($collected);
    }

    public function unserialize($data)
    {
        $collected = unserialize($data);

        $this->accessToken = $collected[0];
        $this->expiryTime = $collected[1];
        $this->tokenType = $collected[2];
    }
}
