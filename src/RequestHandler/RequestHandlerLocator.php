<?php

namespace App\RequestHandler;

use App\RequestHandler\Operation\Operation;

class RequestHandlerLocator implements RequestHandlerLocatorInterface
{
    /**
     * @var RequestHandlerInterface[]
     */
    private $handlers;

    /**
     * DataProvider constructor.
     * @param RequestHandlerInterface[] $handlers
     */
    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @inheritDoc
     * @return WriteRequestHandlerInterface|ReadRequestHandlerInterface
     * @throws RequestHandlerException
     */
    public function getRequestHandler(Operation $operation): RequestHandlerInterface
    {
        $handlerType = $operation instanceof WriteOperation ? WriteRequestHandlerInterface::class : ReadRequestHandlerInterface::class;

        foreach ($this->handlers as $handler) {
            if ($handler instanceof $handlerType && $handler->supports($operation->getDataType())) {
                $handler->setOperation($operation);
                return $handler;
            }
        }

        throw RequestHandlerException::unsupportedOperation($operation);
    }
}