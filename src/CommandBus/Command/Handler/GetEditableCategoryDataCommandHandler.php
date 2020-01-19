<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\GetEditableCategoryDataCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Dto\Category\EditableCategoryDto;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityNotFoundException;

class GetEditableCategoryDataCommandHandler implements CommandHandlerInterface
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * GetEditableCategoryDataCommandHandler constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param GetEditableCategoryDataCommand $command
     *
     * @return EditableCategoryDto
     *
     * @throws EntityNotFoundException
     */
    public function exec($command): EditableCategoryDto
    {
        $filters = $command->getSearch()->getFilters();

        /** @var Category $category */
        $category = $this->categoryRepository->findOneBy($filters);

        if (!$category) {
            // todo: replace with some proper exception
            throw EntityNotFoundException::fromClassNameAndIdentifier(Category::class, $filters);
        }

        $categoryDto = new EditableCategoryDto();
        $categoryDto
            ->setId($category->getId())
            ->setTitle($category->getTitle())
            ->setParentCategoryId($category->getParent() ? $category->getParent()->getId() : null);

        return $categoryDto;
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof GetEditableCategoryDataCommand;
    }
}
