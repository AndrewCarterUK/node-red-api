<?php

namespace NodeRED\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use NodeRED\Instance;

class InstanceFactory
{
    const MOCK_URL = 'https://mock.node-red/';

    public static function getMock(array $responses)
    {
        $mockHandler = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handlerStack]);

        return new Instance(self::MOCK_URL, $client);
    }
}
