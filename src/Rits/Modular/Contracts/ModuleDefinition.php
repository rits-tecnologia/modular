<?php

namespace Rits\Modular\Contracts;

interface ModuleDefinition
{
    /**
     * Bootstrap a new module.
     */
    public function bootstrap(): bool;
}
