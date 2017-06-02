<?php

namespace NodeRED;

class Importer
{
    private $instance;
    private $token;

    public function __construct(Instance $instance, OAuthToken $token)
    {
        $this->instance = $instance;
        $this->token = $token;
    }

    public function importFlow($label, $flowJson)
    {
        $id = uniqid();

        $body = [
            'id' => $id,
            'label' => $label,
            'nodes' => $this->getNodes($id, $flowJson)
        ];

        $data = $this->instance->jsonPost('flow', $body, $this->token);

        return $data['id'];
    }

    private function getNodes($z, $flowJson)
    {
        $rawNodes = json_decode($flowJson, true);

        $idMap = [];

        foreach ($rawNodes as $node) {
            $idMap[$node['id']] = uniqid();
        }

        return array_map(function ($node) use ($z, $idMap){
            $node['id'] = $idMap[$node['id']];
            $node['z'] = $z;

            if (isset($node['wires'])) {
                foreach ($node['wires'] as &$wire) {
                    foreach ($wire as &$id) {
                        $id = $idMap[$id];
                    }
                }
            }

            return $node;
        }, json_decode($flowJson, true));
    }
}
