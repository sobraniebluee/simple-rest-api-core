<?php
namespace Services;

use Api\Interfaces\ResponseInterface as Response;
use Api\Interfaces\RequestInterface as Request;

class User
{
    public function getUser(Request $request, Response $response): Response
    {
        $response
            ->setJson(["message" => "Please...."])
            ->setStatusCode(401);

        return $response;
    }
}