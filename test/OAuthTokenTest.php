<?php

namespace NodeRED\Test;

use NodeRED\OAuthToken;

class OAuthTokenTest extends \PHPUnit_Framework_TestCase
{
    public function testExpiry()
    {
        $validToken = new OAuthToken('', 10, '');
        $expiredToken = new OAuthToken('', -1, '');

        $this->assertFalse($validToken->hasExpired(), 'Valid token has not expired');
        $this->assertTrue($expiredToken->hasExpired(), 'Expired token has expired');
    }

    public function testSerializeAndAuthorizationString()
    {
        $token = new OAuthToken('foo', 10, 'Bearer');

        $serialized = serialize($token);
        $unserializedToken = unserialize($serialized);

        $this->assertEquals('Bearer foo', $unserializedToken->getAuthorizationString());
    }
}
