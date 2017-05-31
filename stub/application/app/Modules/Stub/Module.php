<?php

namespace App\Modules\Stub;

use Rits\Modular\ModuleDefinition;
use Illuminate\Contracts\Routing\Registrar;

class Module extends ModuleDefinition
{
    /**
     * Bind application routes.
     *
     * @param Registrar $router
     * @return void
     */
    public function bindRoutes(Registrar $router): void
    {
        $router->get('/', ['as' => 'stub.index', 'uses' => 'DefaultController@index']);
    }
}
