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
        'VendorPublish' => 'Laravelista\LumenVendorPublish\VendorPublishCommand'
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->commands($this->commands);
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/View', 'apidoc');// 指定视图目录

        $this->loadRoutesFrom(__DIR__ . '/Route/routes.php');

        $this->publishes([
            __DIR__ . '/Static' => base_path('public'),
            __DIR__ . '/Config' => base_path('config')
        ]);
    }
}
