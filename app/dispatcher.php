<?php

require_once __DIR__ . '/routing.php';
$routesCollection = function (FastRoute\RouteCollector $r) use ($routes) {
    foreach ($routes as $controller => $actions) {
        foreach ($actions as $action) {
            $r->addRoute($action[2], $action[1], [$controller,$action[0]]);
        } }};

$dispatcher = FastRoute\simpleDispatcher($routesCollection);

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header("HTTP/1.0 404 Not Found");
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        header("HTTP/1.0 405 Method Not Allowed");
        break;
    case FastRoute\Dispatcher::FOUND:
        $vars = $routeInfo[2];
        list($class, $method) = $routeInfo[1];
        $class = '\Controller\\' . $class . 'Controller';
        echo call_user_func_array([new $class(), $method], $vars);
        break;
}