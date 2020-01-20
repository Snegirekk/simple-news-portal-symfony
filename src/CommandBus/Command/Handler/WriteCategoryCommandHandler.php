<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\WriteCategoryCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Dto\Category\CategoryIdDto;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

class WriteCategoryCommandHandler implements CommandHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * WriteCategoryCommandHandler constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param WriteCategoryCommand $command
     *
     * @return CategoryIdDto
     *
     * @throws ORMException
     */
    public function exec($command): CategoryIdDto
    {
        $data = $command->getData();

        $id = $data->getId();

        /** @var Category $parentCategoryReference */
        $parentCategoryReference = $data->getParentCategoryId()
            ? $this->entityManager->getReference(Category::class, $data->getParentCategoryId())
            : null;

        /** @var Category $category */
        $category = $id ? $this->entityManager->getReference(Category::class, $id) : new Category();
        $category
            ->setTitle($data->getTitle())
            ->setParent($parentCategoryReference);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        $articleDto = new CategoryIdDto();
        $articleDto->setId($category->getId());

        return $articleDto;
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof WriteCategoryCommand;
    }
}
