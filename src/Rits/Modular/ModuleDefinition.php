<?php

namespace Rits\Modular;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\Registrar;
use ReflectionClass;
use Rits\Modular\Contracts\ModuleDefinition as ModuleDefinitionContract;

abstract class ModuleDefinition implements ModuleDefinitionContract
{
    /**
     * Laravel's container instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * ModuleDefinition constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app = null)
    {
        $this->app = $app;
    }

    /**
     * Bootstrap the module.
     *
     * @return bool
     */
    public function bootstrap(): bool
    {
        $this->loadRoutes();

        return true;
    }

    /**
     * Load module's routes.
     *
     * @return void
     */
    protected function loadRoutes(): void
    {
        /** @var Registrar $router */
        $router = $this->app->make('router');
        $namespace = $this->getCurrentNamespace().'\\Controllers';

        $router->group(compact('namespace'), function () use ($router) {
            $this->bindRoutes($router);
        });
    }

    /**
     * Set laravel's container instance.
     *
     * @param Application $app
     */
    public function setApp(Application $app): void
    {
        $this->app = $app;
    }

    /**
     * Get module's full namespace.
     *
     * @return string
     */
    public function getCurrentNamespace(): string
    {
        $reflection = new ReflectionClass($this);

        return $reflection->getNamespaceName();
    }

    /**
     * Bind application routes.
     *
     * @param Registrar $router
     * @return void
     */
    abstract public function bindRoutes(Registrar $router): void;
}
