<?php

namespace Api\ErrorHtpp;

class InternalServerHttpError extends HttpError
{
    protected int $code = 500;
    protected string $message = "Internal server error";
}