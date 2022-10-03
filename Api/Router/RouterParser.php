<?php

namespace Api\Router;


class RouterParser
{

    public static function parseUri($routePath, $queryUri): bool | array
    {
        $routePath[0] = "$";
        $uri[0] = "$";
        $uri = implode("", explode("/", $queryUri,1));
        $uriSchema = explode("/", trim($uri, "/"));
        $routePathSchema = explode("/", trim($routePath, "/"));
        print_r($uriSchema);
        print_r($routePathSchema);
        $params = [];
        if (count($routePathSchema) == count($uriSchema)) {
            for ($i = 0;$i < count($routePathSchema);$i++) {
                if ($routePathSchema[$i] == $uriSchema[$i]) {
                    continue;
                } else if ($routePathSchema[$i][0] == "{" && $routePathSchema[$i][strlen($routePathSchema[$i]) -1] == "}") {
                    $paramName = substr($routePathSchema[$i], 1, strlen($routePathSchema[$i]) - 2);
                    $params[$paramName] = $uriSchema[$i];
                } else {
                    return false;
                }
            }
        }
        return $params;
    }
}

