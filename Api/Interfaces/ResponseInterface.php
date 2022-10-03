<?php

namespace Api\Interfaces;

use Api\Response\Response;

interface ResponseInterface
{
    function setHeader(string $headerName, string $value): Response;
    function setBody(string | array | null $body): Response;
    function setJson(string | array | null $body): Response;
    function setStatusCode(int $statusCode): Response;
}