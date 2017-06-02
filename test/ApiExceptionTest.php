<?php

namespace NodeRED\Test;

use NodeRED\ApiException;
use GuzzleHttp\Psr7\Response;

class ApiExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $response = new Response(401, [], 'Foo');

        $exception = ApiException::fromResponse($response);

        $this->assertEquals(401, $exception->getCode());
        $this->assertEquals('Foo', $exception->getMessage());
        $this->assertSame($response, $exception->getResponse());
    }
}
