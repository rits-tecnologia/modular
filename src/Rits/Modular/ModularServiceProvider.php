<?php

namespace Rits\Modular;

use Rits\Modular\Contracts\ModuleLoader as ModuleLoaderContract;
use Illuminate\Support\ServiceProvider;

class ModularServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return bool
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../../stub/application/config/modular.php' => config_path('modular.php'),
        ], 'rits/modular');

        /** @var ModuleLoaderContract $loader */
        $loader = $this->app->make(ModuleLoaderContract::class);

        return $loader->bootstrap();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ModuleLoaderContract::class, function () {
            return new ModuleLoader;
        });
    }
}
