<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\DeleteCategoryCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteCategoryCommandHandler implements CommandHandlerInterface
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DeleteCategoryCommandHandler constructor.
     *
     * @param CategoryRepository     $categoryRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param DeleteCategoryCommand $command
     */
    public function exec($command): void
    {
        $data = $command->getData();

        $category = $this->categoryRepository->find($data->getId());

        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof DeleteCategoryCommand;
    }
}
