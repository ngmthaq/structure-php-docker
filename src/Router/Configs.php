<?php

namespace Src\Router;

use Exception;

abstract class Configs
{
    /**
     * Routes
     */
    public array $routes = [];

    /**
     * Register a GET route
     * 
     * @param array $configs
     * @example ["path" => "/", "controller" => Controller::class, "action" => "action", "middlewares" => []]
     * @return void
     */
    public function get(array $configs)
    {
        extract($configs);
        if (empty($controller)) throw new Exception("Controller not found");
        if (empty($action)) throw new Exception("Action not found");
        if (empty($path)) throw new Exception("Path not found");
        if (empty($middlewares)) $middlewares = [];
        $method = "GET";
        $this->routes[] = compact("path", "controller", "action", "method", "middlewares");
    }

    /**
     * Register a POST route
     * 
     * @param array $configs
     * @example ["path" => "/", "controller" => Controller::class, "action" => "action", "middlewares" => []]
     * @return void
     */
    public function post(array $configs)
    {
        extract($configs);
        if (empty($controller)) throw new Exception("Controller not found");
        if (empty($action)) throw new Exception("Action not found");
        if (empty($path)) throw new Exception("Path not found");
        if (empty($middlewares)) $middlewares = [];
        $method = "POST";
        $this->routes[] = compact("path", "controller", "action", "method", "middlewares");
    }

    /**
     * Get route config
     * 
     * @param string $path
     * @param string $method
     * @return array|null
     */
    public function getRoute(string $endpoint, string $request_method = "GET")
    {
        $routes = array_values(array_filter($this->routes, function ($route) use ($endpoint, $request_method) {
            extract($route);
            return $path === $endpoint && $method === $request_method;
        }));
        return count($routes) > 0 ? $routes[0] : null;
    }

    /**
     * Get current uri
     * 
     * @return string
     */
    public function getCurrentUri()
    {
        list($uri) = explode("?", $_SERVER["REQUEST_URI"]);
        if (substr($uri, -1) === "/") $uri = substr($uri, 0, strlen($uri) - 1);
        if ($uri === "") return "/";
        return $uri;
    }

    /**
     * Get current request method
     * 
     * @return string
     */
    public function getCurrentRequestMethod()
    {
        return strtoupper($_SERVER["REQUEST_METHOD"]);
    }
}
