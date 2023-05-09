<?php

namespace Api\ErrorHttp;

class UnauthorizedHttpError extends HttpError
{
    protected int $code = 401;
    protected string $message = "The request requires valid user authentication";
}