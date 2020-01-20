<?php

namespace App\CommandBus;

use App\Dto\DtoInterface;

class CommandBus implements CommandBusInterface
{
    /**
     * @var CommandHandlerInterface[]
     */
    private $handlers;

    /**
     * DataProvider constructor.
     *
     * @param CommandHandlerInterface[] $handlers
     */
    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }

    /**
     * @inheritDoc
     *
     * @param $command
     *
     * @return DtoInterface|null
     *
     * @throws CommandBusException
     */
    public function exec($command): ?DtoInterface
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($command)) {
                return $handler->exec($command);
            }
        }

        throw CommandBusException::unsupportedCommand(get_class($command));
    }
}
