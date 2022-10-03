<?php

namespace Api\Interfaces;


interface RouterInterface {
    function route(string $path, array $methods, $class, $action, $middlewares);
}