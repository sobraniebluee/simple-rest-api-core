<?php

namespace Api\ErrorHttp;

class InternalServerHttpError extends HttpError
{
    protected int $code = 500;
    protected string $message = "Internal server error";
}