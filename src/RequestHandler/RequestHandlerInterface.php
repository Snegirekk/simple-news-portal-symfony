<?php

namespace App\RequestHandler;

use App\RequestHandler\Operation\Operation;

interface RequestHandlerInterface
{
    /**
     * @param string $dataType
     * @return bool
     */
    public function supports(string $dataType): bool;

    /**
     * @param Operation $operation
     */
    public function setOperation(Operation $operation): void;
}