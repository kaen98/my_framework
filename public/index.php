<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use ExampleApp\HelloWorld;
use FastRoute\RouteCollector;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Relay\Relay;
use Zend\Diactoros\ServerRequestFactory;
use function DI\create;
use function FastRoute\simpleDispatcher;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// $helloWorld = new \ExampleApp\HelloWorld();
// $helloWorld->announce();

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    HelloWorld::class => create(HelloWorld::class)
]);

$container = $containerBuilder->build();

$routes = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/hello', HelloWorld::class);
});

// 中间件调度器
$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler();
$requestHandler = new Relay($middlewareQueue);
$requestHandler->handle(ServerRequestFactory::fromGlobals());
