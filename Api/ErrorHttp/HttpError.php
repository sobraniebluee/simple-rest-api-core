<?php

namespace Api\ErrorHttp;
use Api\Response\Response;

class HttpError extends Response
{
    protected int $code;
    protected string $message;

    public function __construct()
    {
        parent::__construct();
        parent::setStatusCode($this->code)->setBody(json_encode(["message" => $this->message, "code" => $this->code]));
    }
}