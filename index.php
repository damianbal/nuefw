<?php

ini_set('memory_limit', '512M');

/**
 * Start session
 */
session_start();

/**
 * Autoload classes
 */
 require 'vendor/autoload.php';

/**
 * Config
 */
require 'app/config.php';

/**
 * Setup RedBeanPHP
 */
 \RedBeanPHP\R::setup( 'mysql:host='.$config['db_host'].';dbname='.$config['db_name'].'',
     $config['db_user'], $config['db_pass'] );

/**
 * Router
 */
$router = new \Core\Router();
require 'app/routes.php';

/**
 * Default error routes
 */
$router->get('middleware_error', 'ErrorController', 'middleware_error');
$router->get('method_error', 'ErrorController', 'method_error');


/**
 * Kernel
 */
$kernel = new \Core\Kernel();
$kernel->setRouter($router);
$kernel->setConfig($config);

/**
 * View
 */
\Core\View::$twig_engine = $kernel->getTwigEngine();

/**
 * Input
 */
\Core\Input::$config = $config;

/**
 * Generate route links for view
 */
foreach($router->routes as $r)
{
    \Core\View::set($r['_name'] . "", "index.php?route=" . $r['name']);
    //echo $r['_name'] . "" . " = " . "index.php?route=" . $r['name'] . "<br>";
}

$utils = new \Core\UtilsViewHelper();

/**
 * Inject Session
 *
 */
 /*
foreach($_SESSION as $session_name => $session_value)
{
    \Core\View::set("SESSION_" . $session_name, $session_value);
}*/

/**
 * Application
 */
\App\Application::setup($config, $kernel);
\App\Application::register();

/**
 * Run the application
 */
$kernel->run();
