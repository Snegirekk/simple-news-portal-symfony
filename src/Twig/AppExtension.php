<?php

namespace App\Twig;

use App\CommandBus\Command\GetNavigationCategoriesCommand;
use App\CommandBus\CommandBusInterface;
use App\Dto\Category\NavigationCategoryDto;
use App\Dto\CollectionDtoInterface;
use App\Dto\DtoInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    /**
     * AppExtension constructor.
     *
     * @param CommandBusInterface $commandBus
     */
    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @inheritDoc
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getMenuItems', [$this, 'getMenuItems']),
        ];
    }

    /**
     * @return CollectionDtoInterface|DtoInterface|NavigationCategoryDto[]
     */
    public function getMenuItems(): CollectionDtoInterface
    {
        $command = new GetNavigationCategoriesCommand();
        return $this->commandBus->exec($command);
    }
}
