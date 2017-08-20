<?php

namespace Core;

class Kernel
{
    protected $router      = null;
    protected $twig_engine = null;
    protected $config      = null;

    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem('app/views/');

        $twig = new \Twig_Environment($loader, array(
                   /* 'cache' => 'cache/views', */
        ));

        $this->twig_engine = $twig;
    }

    /**
     * @return void
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwigEngine() { return $this->twig_engine; }

    /**
     *
     * @return void
     */
    public function setRouter($r)
    {
        $this->router = $r;
    }

    public function runRoute($route)
    {
        $r = $this->router->findRoute($route);

        $controller_name = 'Controllers\\' . $r['controller'];
        $method_name     = $r['method'];
        $request_method  = $r['type'];

        if($request_method == $_SERVER['REQUEST_METHOD'])
        {
            $this->runController($controller_name, $method_name);
        }
        else
        {
            //echo "Method not allowed!";
            $this->runRoute('method_error');
        }
    }

    public function runController($controller, $method)
    {
       $c = 'App\\' . $controller;
       $co = new $c();
       echo $co->{$method}();
    }

    /**
     *
     * @return void
     */
    public function run()
    {
        $controller = @$_GET['controller'];
        $method     = @$_GET['method'];
        $route      = @$_GET['route'];

        if(isset($_GET['route']))
        {
            // route
            $this->runRoute($route);
        }
        else if(isset($_GET['controller']) && isset($_GET['method']))
        {
            $this->runController('Controllers\\' . $controller, $method);
        }
        else
        {
            // default route
            $this->runRoute($this->config['default_route']);
        }

        $last_route = $route;
        \Core\Session::session(['last_route' => $last_route]);
    }
}
