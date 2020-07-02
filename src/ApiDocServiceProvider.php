<?php
namespace Pucoder\Apidoc;

use Illuminate\Support\ServiceProvider;

class ApiDocServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        Console\ApiDocCommand::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/View', 'apidoc');

        $this->loadRoutesFrom(__DIR__ . '/Route/routes.php');

        $this->publishes([
            __DIR__ . '/../config' => base_path('config'),
            __DIR__ . '/../static' => base_path('public')
        ]);
    }
}
