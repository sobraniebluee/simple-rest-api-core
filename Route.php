<?php

namespace Api\Router;
use Error;

define("PART_URL","part");
define("PARAM_URl","param");

class Route
{
    public string $path;
    public array $pathSchema;
    public array $methods;
    public string $class;
    public string $action;
    public array $middlewares;

    public function __construct(string $path, $methods, $class, $action, $middlewares)
    {
        $this->pathSchema = $this->parseSchemaPath($path);;
        $this->methods = $methods;
        $this->class = $class;
        $this->action = $action;
        $this->middlewares = $middlewares;
    }
    private function parseSchemaPath($path): array
    {
        /**
         * @return array
         * Return array with path schema
         */
        $schema = [];
        $pattern_error = "/[$&+,:;=\\-_?@#|\".^*()[\]%!\d]/";

        if ($this->checkRulesSchema($path)) {
            $pathSchema = explode("/", $path);
            foreach ($pathSchema as $pathEl) {
                if (str_starts_with($pathEl, "{") ) {
                    if (str_ends_with($pathEl, "}")) {
                        if (preg_match($pattern_error, $pathEl)) {
                            throw new Error("Argument $pathEl have especial chars!");
                        }
                        $pathParam = substr($pathEl, 1, strlen($pathEl) - 2);
                        if (!array_key_exists($pathParam, $schema)) {
                            $schema[$pathParam] = PARAM_URl;
                        } else {
                            throw new Error("Argument $pathEl used twice in " . $path);
                        }
                    } else {
                        throw new Error("Error path schema " . $path);
                    }
                } else {
                    $schema[$pathEl] = PART_URL;
                }
            }
        }
        return $schema;
    }
    private function checkRulesSchema(string &$path): bool
    {
        /**
         * @return bool
         * if path compiles with the rules,then change first char on $ else raise Error
         */
        if (!str_starts_with($path, "/")) {
            throw new Error("Path route must started with slash!");
        }

        for ($i = 0;$i < strlen($path);$i++) {
            if ($path[$i] == "/" and $path[$i+1] == "/") {
                throw new Error("Path route must not have twice slash in row");
            }
        }
        $path[0] = "$";
        return true;
    }
}