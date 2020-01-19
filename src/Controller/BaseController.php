<?php

namespace App\Controller;

use App\CommandBus\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    /**
     * @var CommandBusInterface
     */
    protected $commandBus;

    /**
     * BaseController constructor.
     *
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }
}
