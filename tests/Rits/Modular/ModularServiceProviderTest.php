<?php

namespace Tests\Rits\Modular;

use Rits\Modular\Contracts\ModuleLoader as ModuleLoaderContract;
use Rits\Modular\ModuleLoader;
use Rits\Modular\ModularServiceProvider;
use Mockery;
use Tests\TestCase;

class ModularServiceProviderTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected $underTest = ModularServiceProvider::class;

    /**
     * Parameters used to instantiate class under test.
     *
     * @return array
     */
    protected function constructorArgs()
    {
        return [app()];
    }

    /**
     * register must bind default module loader.
     */
    public function testRegisterBindsModuleLoader()
    {
        $this->invokeInaccessibleMethod('register');

        $this->assertInstanceOf(ModuleLoader::class, app(ModuleLoaderContract::class));
    }

    /**
     * boot must bootstrap module loader.
     */
    public function testBootMustBootstrapLoader()
    {
        /** @var Mockery\Mock $mock */
        $mock = Mockery::mock('Rits\Modular\Contracts\ModuleLoader');
        $mock->shouldReceive('bootstrap')->once()->andReturn(true);

        $this->app->singleton(ModuleLoaderContract::class, function () use ($mock) {
            return $mock;
        });

        $boot = $this->invokeInaccessibleMethod('boot');

        $this->assertTrue($boot);
    }
}
