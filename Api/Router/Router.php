<?php

namespace Api\Router;


use Api\ErrorHtpp;
use Api\Interfaces\RouterInterface;
use Api\Request\Request;
use Api\Response\Response;


class Router implements RouterInterface
{
    protected array $routers = [];
    protected array $methods = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];

    public function route($path, $methods, $class, $action, $middlewares = [])
    {
        $this->routers[] = new Route($path, $methods, $class, $action, $middlewares);
    }

    protected function enable(): Response
    {
        $queryPath = $_SERVER['REQUEST_URI'];
        foreach ($this->routers as $route) {
            $queryPathData = $this->isEqualPathAndGetPathData($route->pathSchema, $queryPath);
            if ($queryPathData) {
                $method = $_SERVER['REQUEST_METHOD'];
                if (!$this->allowMethods($route->methods, $method)) {
                    return new ErrorHtpp\NotAllowedMethodHttpError();
                }
                $request = new Request($queryPathData["params"], $queryPathData["query"]);
                $class = new $route->class;
                $method = $route->action;

                return $class->$method($request, new Response());
            }
        }
        return new ErrorHtpp\NotFoundHttpError();
    }

    protected function isEqualPathAndGetPathData(array $routePathSchema, string $queryPath): false | array
    {

        $urlObject = parse_url($queryPath);
        $parseUrlData = [
            "path" => "",
            "params" => [],
            "query" => []
        ];
        if (isset($urlObject["path"])) {
            $urlPath = $urlObject["path"];
            $parseUrlData["path"] = $urlPath;
            $urlPath[0] = "$"; // for don't remove first slash in explode
            $parsePathUrl = explode("/", $urlPath);

            if (count($parsePathUrl) == count($routePathSchema)) {
                $routePathKeys = array_keys($routePathSchema);
                $routePathValues = array_values($routePathSchema);

                for ($i = 0;$i < count($parsePathUrl);$i++) {
                    if ($parsePathUrl[$i] == $routePathKeys[$i] and $routePathValues[$i] == PART_URL) {
                        continue;
                    } else if ($routePathValues[$i] == PARAM_URl) {
                        $parseUrlData['params'][$routePathKeys[$i]] = $parsePathUrl[$i];
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
        if(isset($urlObject['query'])) {
            parse_str($urlObject['query'],$urlQueryEntries);;
            $parseUrlData["query"] = $urlQueryEntries;
        }
        return $parseUrlData;
    }

    protected function allowMethods($methods, $method): bool
    {
        return (in_array($method, $methods));
    }

}