<?php

require_once __DIR__ . '/vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $route) {
    $route->addRoute('GET', '/', 'ApplicationController@index');
    $route->addRoute('POST', '/', 'ApplicationController@create');
    $route->addRoute('GET', '/deals', 'DealController@index');
    $route->addRoute('POST', '/deals/{id}', 'DealController@offer');

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 'Error 404! Page not found!';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'Error 405! Method not allowed!';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = explode('@', $handler);
        $controllerPath = '\App\Controllers\\' . $controller;
        echo (new $controllerPath)->{$method}($vars);
        break;
}