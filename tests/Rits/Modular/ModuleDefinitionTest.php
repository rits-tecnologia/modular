<?php

namespace Tests\Rits\Modular;

use App\Modules\Stub\Module;
use Illuminate\Routing\Router;
use Rits\Modular\ModuleDefinition;
use Tests\TestCase;

class ModuleDefinitionTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected $underTest = Module::class;

    /**
     * Example of modules configuration.
     *
     * @var array|null
     */
    protected $modules = null;

    /**
     * Hook to be called after construction.
     *
     * @param Module $instance
     */
    protected function constructorHooks($instance)
    {
        $instance->setApp($this->app);
    }

    /**
     * Setup module configuration file.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        /* @noinspection PhpIncludeInspection */
        $this->modules = require realpath(__DIR__.'/../../../stub/tests/modular.php');

        config(['modular' => $this->modules]);
    }

    /**
     * Class under test must be instantiable without parameters.
     */
    public function testIsInstantiable()
    {
        $this->assertInstanceOf(ModuleDefinition::class, $this->getReflection()->newInstance($this->app));
    }

    /**
     * getCurrentNamespace must return module namespace.
     */
    public function testModulesPathIsCorrect()
    {
        $namespace = $this->invokeInaccessibleMethod('getCurrentNamespace');

        $this->assertEquals('App\\Modules\\Stub', $namespace);
    }

    /**
     * loadRoutes must load example routes.
     */
    public function testRoutesWereLoaded()
    {
        /* @var \Illuminate\Routing\Router $router */
        $this->invokeInaccessibleMethod('loadRoutes');

        $this->assertRouting();
    }

    /**
     * bootstrap must run smoothly for existing methods.
     */
    public function testRunsSmoothlyForExistingMethods()
    {
        $bootstrap = $this->invokeInaccessibleMethod('bootstrap');

        $this->assertTrue($bootstrap);
        $this->assertRouting();
    }

    /**
     * Generic route asserting.
     */
    private function assertRouting()
    {
        $router = app(Router::class);
        $action = $router->getRoutes()->getByName('stub.index')->getAction();

        $this->assertTrue($router->has('stub.index'));
        $this->assertEquals('App\\Modules\\Stub\\Controllers', $action['namespace']);
    }
}
