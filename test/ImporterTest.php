<?php

namespace NodeRED\Test;

use NodeRED\Instance;
use NodeRED\Importer;
use NodeRED\OAuthToken;

class ImporterTest extends \PHPUnit_Framework_TestCase
{
    public function testImport()
    {
        $token = new OAuthToken('', '', '');

        $mockInstance = $this
            ->getMockBuilder(Instance::class)
            ->disableOriginalConstructor()
            ->setMethods(['jsonPost'])
            ->getMock();

        $mockInstance
            ->expects($this->once())
            ->method('jsonPost')
            ->with(
                $this->equalTo('flow'),
                $this->callback(function ($flow) {
                    $this->assertArrayHasKey('id', $flow, 'Flow has id');
                    $this->assertArrayHasKey('label', $flow, 'Flow has label');
                    $this->assertEquals('Test Flow', $flow['label'], 'Flow label is correct');

                    $id = $flow['id'];

                    foreach ($flow['nodes'] as $node) {
                        $this->assertArrayHasKey('id', $node, 'Node has id');
                        $this->assertArrayHasKey('z', $node, 'Node has parent id');
                        $this->assertEquals($id, $node['z'], 'Node has correct parent id');
                    }

                    return true;
                }),
                $this->equalTo($token)
            )
            ->willReturn(['id' => 'foo']);

        $importer = new Importer($mockInstance, new OAuthToken('', '', ''));

        $flowJson = '[{"id":"38fb694f.83ac86","type":"inject","z":"7578d4d1.ba2e2c","name":"","topic":"","payload":"","payloadType":"date","repeat":"","crontab":"","once":false,"x":602.5,"y":298,"wires":[["f8ac9ac8.c76808"]]},{"id":"f8ac9ac8.c76808","type":"debug","z":"7578d4d1.ba2e2c","name":"","active":true,"console":"false","complete":"false","x":794.5,"y":298,"wires":[]}]';

        $id = $importer->importFlow('Test Flow', $flowJson);

        $this->assertEquals('foo', $id);
    }
}
