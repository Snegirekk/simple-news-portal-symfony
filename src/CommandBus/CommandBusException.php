<?php

namespace App\CommandBus;

use Exception;

class CommandBusException extends Exception
{
    /**
     * @param string $commandName
     *
     * @return static
     */
    public static function unsupportedCommand(string $commandName): self
    {
        return new self(sprintf('Couldn\'t find handler for "%s" command.', $commandName));
    }
}
