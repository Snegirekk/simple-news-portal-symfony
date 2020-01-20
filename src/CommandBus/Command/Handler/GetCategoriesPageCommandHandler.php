<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\GetCategoriesPageCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Dto\Category\EditableCategoryDto;
use App\Dto\CollectionDto;
use App\Dto\PageDto;
use App\Repository\CategoryRepository;

class GetCategoriesPageCommandHandler implements CommandHandlerInterface
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
     * @param GetCategoriesPageCommand $command
     *
     * @return EditableCategoryDto[]|PageDto
     */
    public function exec($command)
    {
        $pagination = $command->getPagination();

        $categoriesPaginator = $this->categoryRepository->getCategoriesPage($pagination, $command->getSearch());
        $collection = new CollectionDto(EditableCategoryDto::class);

        foreach ($categoriesPaginator as $category) {
            $parentCategoryId = $category->getParent() ? $category->getParent()->getId() : null;

            $categoryDto = new EditableCategoryDto();
            $categoryDto
                ->setId($category->getId())
                ->setTitle($category->getTitle())
                ->setParentCategoryId($parentCategoryId);

            $collection->add($categoryDto);
        }

        $totalPages = max(ceil($categoriesPaginator->count() / $pagination->getItemsPerPage()), 1);

        return new PageDto($collection, $pagination->getPage(), $pagination->getItemsPerPage(), $totalPages);
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof GetCategoriesPageCommand;
    }
}
