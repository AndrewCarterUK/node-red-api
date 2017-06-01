<?php

namespace NodeRED\Test;

use GuzzleHttp\Psr7\Response;

class InstanceTest extends \PHPUnit_Framework_TestCase
{
    const MOCK_URL = 'https://MOCK/';

    /**
     * @expectedException NodeRED\ApiException
     * @expectedExceptionCode 401
     */
    public function test401()
    {
        $instance = InstanceFactory::getMock([new Response(401)]);
        $instance->get('flows');
    }

    /**
     * @expectedException NodeRED\ApiException
     * @expectedExceptionCode 0
     */
    public function testBadJson()
    {
        $instance = InstanceFactory::getMock([new Response(200, ['Content-Type' => 'application/json'], 'foo')]);
        $instance->get('flows');
    }
}
