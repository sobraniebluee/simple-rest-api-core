<?php

namespace Api\Response;


class ResponseEmitter
{
    protected Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function sendResponse(): void
    {
        $this->sendStatusCode();
        $this->sendHeaders();
        $this->sendBody();
        exit();
    }

    private function sendBody(): void
    {
        $body = $this->response->getBody();
        if ($body) {
            echo ($body);
        }
    }

    private function sendHeaders(): void
    {
        foreach ($this->response->getHeaders() as $header) {
            header($header['headerName'] . ": " . $header["headerValue"]);
        }
    }

    private function sendStatusCode(): void
    {
        http_response_code($this->response->getStatusCode());
    }
}