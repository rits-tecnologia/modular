<?php

namespace Rits\Modular\Contracts;

use Rits\Modular\Exceptions\InvalidSignatureException;
use Rits\Modular\Exceptions\ModuleNotFoundException;

interface ModuleLoader
{
    /**
     * Start all module loader logic.
     *
     * @throws InvalidSignatureException module doesn't implement the right interface
     * @throws ModuleNotFoundException module doesn't exists
     * @return bool
     */
    public function bootstrap(): bool;
}
