<?php

/**
 * Front controller
 * 
 * PHP 7.4
 */

 // vendor autoloading
require_once dirname(__DIR__) . '/vendor/autoload.php';


//Not necessary as I'm using composer class autoloader
// spl_autoload_register(function ($class) {
//     $root = dirname(__DIR__);
//     $class_path = str_replace('\\', '/', $class);
//     $file = $root . '/' . $class_path . '.php';
//     if (is_readable($file)){
//         require $file;
//     }
// });

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


$router = new Core\Router();

$url = $_SERVER['QUERY_STRING'];


//routes
$router->addByStrings('', 'Home', 'index');
$router->add('{controller}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('{controller}/{id:\d+}/{action}');

$router->dispatch($url);
