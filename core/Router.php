<?php

namespace Core;

/**
 * RouteGroup
 */
class RouteGroup
{
    public $controller;
    public $routes;
    public $route_name;
    public $router;

    public function __construct($router)
    {
        $this->router = $router;
    }

    /**
     *
     *
     * @param $name string
     * @param $ctrl string
     *
     * @return \Core\RouteGroup
     */
    public function builder($name, $ctrl) : \Core\RouteGroup
    {
        $this->controller = $ctrl;
        $this->route_name = $name;

        return $this;
    }

    /**
     *
     *
     * @param $name string
     * @param $ctrl string
     *
     * @return \Core\RouteGroup
     */
    public function get($name, $method) : \Core\RouteGroup
    {

        $this->router->routes[$this->route_name . "." . $name] = [
            'name' => $this->route_name . "." . $name,
            '_name' => $this->route_name . "_" . $name,
            'type' => 'GET',
            'controller' => $this->controller,
            'method' => $method
        ];

        return $this;
    }

    /**
     *
     *
     * @param $name string
     * @param $ctrl string
     *
     * @return \Core\RouteGroup
     */
    public function post($name, $method) : \Core\RouteGroup
    {

        $this->router->routes[$this->route_name . "." . $name] = [
            'name' => $this->route_name . "." . $name,
            '_name' => $this->route_name . "_" . $name,
            'type' => 'POST',
            'controller' => $this->controller,
            'method' => $method
        ];

        return $this;
    }
}

/**
 * Router
 */
class Router
{
    public $routes = [];

    public function findRoute($route)
    {
        foreach($this->routes as $key => $value)
        {
            if($key == $route) {
                return $value;
            }
        }
    }

    public function group($name, $ctrl)
    {
        return (new RouteGroup($this))->builder($name, $ctrl);
    }

    /**
     * Define route
     *
     * @param $type string
     * @param $name string
     * @param $controller string
     * @param $method string
     *
     * @return void
     */
    protected function route($type, $name, $controller, $method)
    {
        $this->routes[$name] = [
            'name' => $name,
            '_name' => str_replace('.', '_', $name),
            'type' => $type,
            'controller' => $controller,
            'method'     => $method,
        ];
    }

    /**
     * Define GET route
     *
     * @param $name string
     * @param $controller string
     * @param $method string
     *
     * @return void
     */
    public function get($name, $controller, $method)
    {
        $this->route('GET', $name, $controller, $method);
    }

    /**
     * Define POST route
     *
     * @param $name string
     * @param $controller string
     * @param $method string
     *
     * @return void
     */
     public function post($name, $controller, $method)
     {
        $this->route('POST', $name, $controller, $method);
     }
}
