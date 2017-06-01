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
        $collected = [$accessToken, $expiryTime, $tokenType];

        return serialize($collected);
    }

    public function unserialize($data)
    {
        $collected = unserialize($data);

        $this->accessToken = $data[0];
        $this->expiryTime = $data[1];
        $this->tokenType = $data[2];
    }
}
