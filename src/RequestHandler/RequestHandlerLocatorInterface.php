<?php

namespace App\RequestHandler;

use App\RequestHandler\Operation\Operation;

interface RequestHandlerLocatorInterface
{
    /**
     * @param Operation $operation
     * @return RequestHandlerInterface
     */
    public function getRequestHandler(Operation $operation): RequestHandlerInterface;
}