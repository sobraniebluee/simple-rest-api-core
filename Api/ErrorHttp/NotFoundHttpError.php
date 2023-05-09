<?php

namespace Api\ErrorHttp;

use Api\Response\Response;

class NotFoundHttpError extends HttpError
{
    protected string $message = "Not found";
    protected int $code = 404;
}