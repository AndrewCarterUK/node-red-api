<?php

namespace NodeRED\Test;

use GuzzleHttp\Psr7\Response;
use NodeRED\OAuth;
use NodeRED\OAuthToken;

class OAuthTest extends \PHPUnit_Framework_TestCase
{
    const MOCK_URL = 'https://MOCK/';

    public function testGetToken()
    {
        $successJson = '{"access_token": "A_SECRET_TOKEN","expires_in":604800,"token_type": "Bearer"}';
        $response = new Response(200, ['Content-Type' => 'application/json'], $successJson);

        $instance = InstanceFactory::getMock([$response]);

        $oAuth = new OAuth($instance);

        $token = $oAuth->getToken($username, $password);

        $this->assertInstanceOf(OAuthToken::class, $token);
    }
}
