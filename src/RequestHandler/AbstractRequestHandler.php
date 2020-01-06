<?php

namespace App\RequestHandler;

use App\RequestHandler\Operation\Operation;
use App\RequestHandler\Operation\ReadOperation;
use App\RequestHandler\Operation\WriteOperation;

abstract class AbstractRequestHandler implements RequestHandlerInterface
{
    /**
     * @var Operation|ReadOperation|WriteOperation
     */
    protected $operation;

    /**
     * @inheritDoc
     */
    public function setOperation(Operation $operation): void
    {
        $this->operation = $operation;
    }
}