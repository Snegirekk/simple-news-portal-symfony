<?php

namespace App\CommandBus;

interface CommandHandlerInterface
{
    /**
     * @param mixed $command
     *
     * @return mixed
     */
    public function exec($command);

    /**
     * Used to choose the right command handler
     *
     * @param mixed $command
     *
     * @return bool
     */
    public function supports($command): bool;
}
