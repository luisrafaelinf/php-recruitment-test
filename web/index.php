<?php

use Snowdog\DevTest\Component\Menu;
use Snowdog\DevTest\Component\RouteRepository;

use Snowdog\DevTest\Constant\ConstantValue;
use Snowdog\DevTest\Constant\SessionValue;

session_start();
define('WEB_DIR', __DIR__);
$container = require __DIR__ . '/../app/bootstrap.php';

$routeRepository = RouteRepository::getInstance();

$dispatcher = \FastRoute\simpleDispatcher($routeRepository);

Menu::setContainer($container);

$route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
switch ($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        header("HTTP/1.0 404 Not Found");
        require __DIR__ . '/../src/view/404.phtml';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        header("HTTP/1.0 405 Method Not Allowed");
        require __DIR__ . '/../src/view/405.phtml';
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $route[1];
        $parameters = $route[2];
        $container->call($controller, $parameters);
        break;
}

if (http_response_code() == ConstantValue::FORBIDDEN)
{
    if (!isset($_SESSION[SessionValue::LOGIN])) {
        header('Location: /login');
    } else {
        header($_SERVER[SessionValue::SERVER_PROTOCOL] . "403 Forbidden");
        require __DIR__ . '/../src/view/403.phtml';
    }


}
