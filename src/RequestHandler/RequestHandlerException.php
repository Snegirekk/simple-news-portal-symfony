<?php

namespace App\RequestHandler;

use Exception;
use App\RequestHandler\Operation\Operation;

class RequestHandlerException extends Exception
{
    /**
     * @param Operation $operation
     * @return static
     */
    public static function unsupportedOperation(Operation $operation): self
    {
        $operationType = $operation instanceof WriteOperation ? 'write' : 'read';
        return new self(sprintf('Couldn\'t find handlers to %s %s.', $operationType, $operation->getDataType()));
    }

    /**
     * @param Operation $operation
     * @param string $method
     * @return static
     */
    public static function unimplementedAction(Operation $operation, string $method): self 
    {
        $operationType = $operation instanceof WriteOperation ? 'write' : 'read';
        return new self(sprintf('Couldn\'t %s %s due to unimplemented "%s" method.', $operationType, $operation->getDataType(), $method));
    }

    /**
     * @param Operation $operation
     * @param string $requirementMessage
     * @return static
     */
    public static function unsatisfiedRequirement(Operation $operation, string $requirementMessage): self
    {
        $operationType = $operation instanceof WriteOperation ? 'write' : 'read';
        return new self(sprintf('Couldn\'t %s %s due to unsatisfied requirement: %s.', $operationType, $operation->getDataType(), $requirementMessage));
    }
}