<?php
    header('Content-Type: application/json');

    require_once './services/Router.php';

    $method = $_SERVER['REQUEST_METHOD'];
    $route = $_SERVER['REQUEST_URI'];

    $router = new Router();
    $response = $router->handaleRequest($method, $route);

    echo $response;
?>