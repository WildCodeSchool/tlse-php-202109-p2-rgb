<?php

// Get the required route (without query string) and remove trailing slashes
$route = trim($_SERVER['PATH_INFO'] ?? '', '/');

// $routes comes from 'routes.php' required here
$routes = require_once __DIR__ . '/../src/routes.php';

// If required route is not is $routes, return a 404 Page not found error
if (!key_exists($route, $routes)) {
    header("HTTP/1.0 404 Not Found");
    echo '404 - Page not found';
    exit();
}

// Get the matching route in $routes array
$matchingRoute = $routes[$route];

// Get the FQCN of controller associated to the matching route
$controller = 'App\\Controller\\' . $matchingRoute[0];
// Get the method associated to the matching route
$method = $matchingRoute[1];
// Get the queryString values configured for the matching route (in $_GET superglobal).
// If there are additional queryString parameters, they are ignored here, and should be
// directly manage in the controller
$parameters = [];
foreach ($matchingRoute[2] ?? [] as $parameter) {
    $parameters[] = $_GET[$parameter] ?? null;
}

// instance the controller, call the method with given parameters
// controller method will return a twig template (HTML string) which is displayed here
echo (new $controller())->$method(...$parameters);
