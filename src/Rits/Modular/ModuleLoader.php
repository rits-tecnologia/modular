<?php

namespace Rits\Modular;

use Illuminate\Contracts\Foundation\Application;
use Rits\Modular\Contracts\ModuleDefinition as ModuleDefinitionContract;
use Rits\Modular\Contracts\ModuleLoader as ModuleLoaderContract;
use Rits\Modular\Exceptions\InvalidSignatureException;
use Rits\Modular\Exceptions\ModuleNotFoundException;

class ModuleLoader implements ModuleLoaderContract
{
    /**
     * Laravel's container instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * ModuleLoader constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app = null)
    {
        $this->app = $app;
    }

    /**
     * Start all module loader logic.
     *
     * @throws InvalidSignatureException module doesn't implement the right interface
     * @throws ModuleNotFoundException module doesn't exists
     * @return bool
     */
    public function bootstrap(): bool
    {
        $loaded = true;

        foreach ($this->getModulesList() as $module) {
            $loaded = $loaded && $this->enableModule($module);
        }

        return $loaded;
    }

    /**
     * Get list from all modules from a config file.
     *
     * @return string[]
     */
    protected function getModulesList(): array
    {
        $modules = config('modular.available', []);
        ksort($modules);

        return array_values($modules);
    }

    /**
     * Load a single module by it's name.
     *
     * @param string $type
     * @throws InvalidSignatureException module doesn't implement the right interface
     * @throws ModuleNotFoundException module doesn't exists
     * @return bool
     */
    protected function enableModule($type): bool
    {
        if (! (class_exists($type) || $this->app->bound($type))) {
            throw new ModuleNotFoundException("Module {$type} does'nt exist");
        }

        /** @var ModuleDefinitionContract $module */
        $module = $this->app->make($type);

        if (! $module instanceof ModuleDefinitionContract) {
            throw new InvalidSignatureException("Class {$type} must implements ModuleDefinition interface");
        }

        $module->setApp($this->app);

        return $module->bootstrap();
    }
}
