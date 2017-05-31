<?php

namespace Tests\Rits\Modular;

use Rits\Modular\ModuleLoader;
use Mockery;
use Tests\TestCase;

class ModuleLoaderTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected $underTest = ModuleLoader::class;

    /**
     * Example of modules configuration.
     *
     * @var array|null
     */
    protected $modules = null;

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
     * Parameters used to instantiate class under test.
     *
     * @return array
     */
    protected function constructorArgs()
    {
        return [app()];
    }

    /**
     * Class under test must be instantiable.
     */
    public function testIsInstantiable()
    {
        $this->assertInstanceOf(ModuleLoader::class, $this->getReflection()->newInstance());
    }

    /**
     * getModulesList must return an array.
     */
    public function testListOfModulesIsAnArray()
    {
        $actual = $this->invokeInaccessibleMethod('getModulesList');

        $this->assertInternalType('array', $actual);
    }

    /**
     * getModulesList must have prioritized the array.
     */
    public function testListOfModulesIsPrioritized()
    {
        $actual = $this->invokeInaccessibleMethod('getModulesList');

        $this->assertEquals(['App\\Modules\\Frontend\\Module', 'App\\Modules\\Other\\Module'], $actual);
    }

    /**
     * enableModule must enable module by it's name.
     */
    public function testSuccessfullyBootsExistingModule()
    {
        /** @var Mockery\Mock $mock */
        $mock = Mockery::mock('Rits\Modular\Contracts\ModuleDefinition');
        $mock->shouldReceive('setApp')->once();
        $mock->shouldReceive('bootstrap')->once()->andReturn(true);
        $this->app->instance('App\\Modules\\Frontend\\Module', $mock);

        $loaded = $this->invokeInaccessibleMethod('enableModule', ['App\\Modules\\Frontend\\Module']);

        $this->assertTrue($loaded);
    }

    /**
     * enableModule must fail to load nonexistent module.
     *
     * @expectedException \Rits\Modular\Exceptions\ModuleNotFoundException
     * @expectedExceptionMessage Module nonexistent does'nt exist
     */
    public function testThrowsSemanticExceptionWhenModuleDoesNotExists()
    {
        $this->invokeInaccessibleMethod('enableModule', ['nonexistent']);
    }

    /**
     * enableModule must fail to load module with wrong signature.
     *
     * @expectedException \Rits\Modular\Exceptions\InvalidSignatureException
     * @expectedExceptionMessage Class App\Modules\Frontend\Module must implements ModuleDefinition interface
     */
    public function testThrowsSemanticExceptionWhenModuleDoesNotImplementRightInterface()
    {
        /** @var Mockery\Mock $mock */
        $mock = Mockery::mock('Rits\Modular\Contracts\WrongModuleDefinition');
        $this->app->instance('App\\Modules\\Frontend\\Module', $mock);

        $this->invokeInaccessibleMethod('enableModule', ['App\\Modules\\Frontend\\Module']);
    }

    /**
     * bootstrap must run smoothly for existing methods.
     */
    public function testRunsSmoothlyForExistingMethods()
    {
        /** @var Mockery\Mock $mock */
        $mock = Mockery::mock('Rits\Modular\Contracts\ModuleDefinition');
        $mock->shouldReceive('setApp')->twice();
        $mock->shouldReceive('bootstrap')->twice()->andReturn(true);
        $this->app->instance('App\\Modules\\Frontend\\Module', $mock);
        $this->app->instance('App\\Modules\\Other\\Module', $mock);

        $bootstrap = $this->invokeInaccessibleMethod('bootstrap');

        $this->assertTrue($bootstrap);
    }
}
