<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Modular Configuration
    |--------------------------------------------------------------------------
    |
    | This option controls where the application modules will be locates. The
    | `available` array lists all modules that should be loaded when the
    | service provider boots up. The key from the enabled array determines the
    | priority loading the modules.
    |
    */

    'available' => [
        10 => 'App\\Modules\\Other\\Module',
        0 => 'App\\Modules\\Frontend\\Module',
    ],

];
