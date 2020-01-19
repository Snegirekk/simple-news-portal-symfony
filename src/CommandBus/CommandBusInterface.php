<?php

namespace App\CommandBus;

use App\Dto\DtoInterface;

interface CommandBusInterface
{
    /**
     * @param mixed $command A command object for execution
     *
     * @return DtoInterface|null
     */
    public function exec($command): ?DtoInterface;
}
