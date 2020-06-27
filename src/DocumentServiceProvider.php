<?php
namespace Coderpu\Document;

use Illuminate\Support\ServiceProvider;

class DocumentServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // 注册中间件
        $this->app->routeMiddleware(['api.doc' => Middleware\DocumentMiddleware::class]);
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/View', 'document');// 指定视图目录

        $this->loadRoutesFrom(__DIR__ . '/Route/routes.php');

        $this->publishes([
            __DIR__ . '/apidoc.sh' => base_path()
        ]);
    }
}
