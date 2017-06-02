<?php

namespace NodeRED;

use GuzzleHttp\Client;

class Instance
{
    private $endpoint;
    private $client;

    public function __construct($endpoint, Client $client = null)
    {
        if (null === $client) {
            $client = new Client();
        }

        $this->endpoint = $endpoint;
        $this->client = $client;
    }

    public function get($path, $token = null)
    {
        return $this->makeRequest('GET', $path, [], $token);
    }

    public function formPost($path, $data, $token = null)
    {
        return $this->makeRequest('POST', $path, ['form_params' => $data], $token);
    }

    public function jsonPost($path, $data, $token = null)
    {
        return $this->makeRequest('POST', $path, ['json' => $data], $token);
    }

    private function makeRequest($method, $path, $extraOptions = [], $token = null)
    {
        $options = [
            'headers' => [
                'Node-RED-API-Version' => 'v2',
            ],
            'http_errors' => false,
        ];

        if (null !== $token) {
            $options['headers']['Authorization'] = $token->getAuthorizationString();
        }

        $response = $this->client->request($method, $this->endpoint . $path, array_merge($options, $extraOptions));

        return $this->processResponse($response);
    }

    private function processResponse(ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode >= 300) {
            throw ApiException::fromResponse($response);
        }

        $json = json_decode($response->getBody(), true);

        if (NULL === $json) {
            throw new ApiException('Could not get JSON from response', 0, $response);
        }

        return $json;
    }
}
