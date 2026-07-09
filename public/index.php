<?php

declare(strict_types=1);

use BabelForge\BabelChromeLaravelModule\LaravelModulePage;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\CallableDispatcher;
use Illuminate\Routing\Contracts\CallableDispatcher as CallableDispatcherContract;
use Illuminate\Routing\Router;

require dirname(__DIR__).'/vendor/autoload.php';

$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$requestPath = is_string($requestUri) ? parse_url($requestUri, PHP_URL_PATH) : '';
if ('/health' === $requestPath) {
    http_response_code(200);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'ok';

    return;
}

$container = new Container();
Container::setInstance($container);
$container->instance('app', $container);
$container->instance(Container::class, $container);
$container->singleton(CallableDispatcherContract::class, static fn (Container $container): CallableDispatcher => new CallableDispatcher($container));

$router = new Router(new Dispatcher($container), $container);
$router->get('/{path?}', static function (Request $request): Response {
    $serverString = static function (string $name, string $default): string {
        $value = $_SERVER[$name] ?? null;

        return is_string($value) ? $value : $default;
    };
    $headerString = static function (Request $request, string $name, string $default): string {
        $value = $request->headers->get($name, $default);

        return is_string($value) ? $value : $default;
    };
    $route = $headerString($request, 'X-BabelChrome-Module-Route', '');
    if ('' === $route) {
        $route = trim($request->path(), '/');
    }
    if ('' === $route) {
        $route = $serverString('BABELCHROME_MODULE_ROUTE', 'index');
    }

    return new Response(
        new LaravelModulePage()->render(
            $serverString('BABELCHROME_MODULE_ID', 'unknown'),
            $route,
            $headerString($request, 'X-BabelChrome-Source-Url', $serverString('BABELCHROME_SOURCE_URL', '')),
            $headerString($request, 'X-BabelChrome-Module-Asset-Base-Url', $serverString('BABELCHROME_MODULE_ASSET_BASE_URL', '')),
            $serverString('BABELCHROME_MODULE_ASSET_TOKEN_QUERY', ''),
        ),
        Response::HTTP_OK,
        ['Content-Type' => 'text/html; charset=utf-8'],
    );
})->where('path', '.*');

$response = $router->dispatch(Request::capture());
if ('cli-server' === PHP_SAPI) {
    $response->send();
}

return $response;
