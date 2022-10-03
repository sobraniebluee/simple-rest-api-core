<?php

namespace Api\Response;

use Api\Interfaces\ResponseInterface;

class Response implements ResponseInterface
{
    private array $headers = [];
    private string | array | null $body = null;
    private int | null $statusCode = null;

    public function __construct() {}

    public function setHeader($headerName, $value): Response
    {
        $header = explode("-", $headerName);
        for ($i = 0;$i < count($header);$i++) {
            $header[$i] = ucfirst($header[$i]);
        }
        $header = implode("-", $header);
        $this->headers[] = [
            "headerName" => $header,
            "headerValue" => $value
        ];
        return $this;
    }
    public function setBody($body): Response
    {
        $this->body = $body;
        return $this;
    }
    public function setStatusCode($statusCode): Response
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    public function setJson(array|string|null $body): Response
    {
        $this->body = json_encode($body);
        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }
    public function getStatusCode(): int | null
    {
        return $this->statusCode;
    }
    public function getBody(): array | string | null
    {
        return $this->body;
    }
}