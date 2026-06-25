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

$container = new Container();
Container::setInstance($container);
$container->instance('app', $container);
$container->instance(Container::class, $container);
$container->singleton(CallableDispatcherContract::class, static fn (Container $container): CallableDispatcher => new CallableDispatcher($container));

$router = new Router(new Dispatcher($container), $container);
$router->get('/{path?}', static function (): Response {
    $serverString = static function (string $name, string $default): string {
        $value = $_SERVER[$name] ?? null;

        return is_string($value) ? $value : $default;
    };

    return new Response(
        new LaravelModulePage()->render(
            $serverString('BABELCHROME_MODULE_ID', 'unknown'),
            $serverString('BABELCHROME_MODULE_ROUTE', 'index'),
            $serverString('BABELCHROME_SOURCE_URL', ''),
            $serverString('BABELCHROME_MODULE_ASSET_BASE_URL', ''),
            $serverString('BABELCHROME_MODULE_ASSET_TOKEN_QUERY', ''),
        ),
        Response::HTTP_OK,
        ['Content-Type' => 'text/html; charset=utf-8'],
    );
})->where('path', '.*');

return $router->dispatch(Request::capture());
