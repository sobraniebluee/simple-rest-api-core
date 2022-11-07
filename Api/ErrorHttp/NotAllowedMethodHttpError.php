<?php

namespace Api\ErrorHtpp;

class NotAllowedMethodHttpError extends HttpError
{
    protected int $code = 405;
    protected string $message = "Method Not Allowed";
}