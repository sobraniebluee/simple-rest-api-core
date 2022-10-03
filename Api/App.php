<?php

namespace Api;
use Api\Response\ResponseEmitter;
use Api\Router\Router;
use Api\Interfaces\AppInterface;


class App extends Router implements AppInterface
{

    public function __construct()
    {
    }

    public function run(): void
    {
        $response = $this->enable();
        $responseEmitter = new ResponseEmitter($response);
        $responseEmitter->sendResponse();
    }
}