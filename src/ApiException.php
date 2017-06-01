<?php

namespace NodeRED;

use Psr\Http\Message\ResponseInterface;

class ApiException extends \RuntimeException
{
    private $response;

    public function __construct($message, $code, ResponseInterface $response)
    {
        $this->response = $response;

        parent::__construct($message, $code);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public static function fromResponse(ResponseInterface $response)
    {
        return new self((string) $response->getBody(), $response->getStatusCode(), $response);
    }
}
