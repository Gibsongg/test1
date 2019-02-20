<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use DI\ContainerBuilder;

header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: "GET, POST, DELETE, PUT, OPTIONS, HEAD"');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization, X-Requested-With, Accept');



error_clear_last();

//TODO: сделать конфигурацию роутов через объект
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/local/library/api/config/main.php');
    /**
     * @var $config stdClass
     */
    foreach ($config->routes as $route) {
        $r->addRoute(
            $route['method'],
            '/1.0' . $route['template'],
            ['api\controllers\\' . $route['controller'] . 'Controller', 'action' . $route['action']]);
    }
});

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
        echo json_encode([
            'status' => 404,
            'message' => 'HTTP/1.0 404 Not Found',
            'data' => null
        ]);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo json_encode([
            'status' => 405,
            'message' => '405 Method Not Allowed',
            'data' => null
        ]);

        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $json = [];

        try {
            $container = ContainerBuilder::buildDevContainer();
            $controller = $container->call($handler, $vars);

            $json = [
                'status' => 200,
                'message' => 'ok',
                'data' => $controller
            ];
        } catch (\Exception $e) {

            $code = $e->getCode();

            if($e->getCode() === 0) {
                $code = 500;
            }

            header("HTTP/1.0 {$code} Server Error");

            $LogsService = $container->get(\api\services\security\LogsService::class);
            $LogsService->errorException($uri, $e);

            $json = [
                'status' => $code,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }

        echo json_encode($json, JSON_UNESCAPED_UNICODE);


        break;
}


