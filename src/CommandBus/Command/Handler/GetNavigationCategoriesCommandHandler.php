<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\GetNavigationCategoriesCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Dto\Category\NavigationCategoryDto;
use App\Dto\CollectionDto;
use App\Dto\CollectionDtoInterface;
use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\Collection;

class GetNavigationCategoriesCommandHandler implements CommandHandlerInterface
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryHandler constructor.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param GetNavigationCategoriesCommand $command
     *
     * @return CollectionDtoInterface
     */
    public function exec($command): CollectionDtoInterface
    {
        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findBy(['parent' => null]);
        $categoryDtos = new CollectionDto(NavigationCategoryDto::class);

        foreach ($categories as $category) {
            $categoryDto = new NavigationCategoryDto();
            $categoryDto
                ->setId($category->getId())
                ->setTitle($category->getName());

            $this->setSubcategories($categoryDto);

            if (!$this->getActiveArticles($category)->isEmpty() || !empty($categoryDto->getSubcategories())) {
                $categoryDtos->add($categoryDto);
            }
        }

        return $categoryDtos;
    }

    /**
     * @param NavigationCategoryDto $categoryDto
     */
    private function setSubcategories(NavigationCategoryDto $categoryDto): void
    {
        /** @var Category[] $subcategories */
        $subcategories = $this->categoryRepository->findBy(['parent' => $categoryDto->getId()]);
        $subcategoryDtos = [];

        foreach ($subcategories as $subcategory) {
            $subcategoryDto = new NavigationCategoryDto();
            $subcategoryDto
                ->setId($subcategory->getId())
                ->setTitle($subcategory->getName());

            $this->setSubcategories($subcategoryDto);

            if (!$this->getActiveArticles($subcategory)->isEmpty() || !empty($subcategoryDto->getSubcategories())) {
                $subcategoryDtos[] = $subcategoryDto;
            }
        }

        $categoryDto->setSubcategories($subcategoryDtos);
    }

    /**
     * @param Category $category
     *
     * @return Collection
     */
    private function getActiveArticles(Category $category): Collection
    {
        return $category->getArticles()->filter(function (Article $article) {
            return $article->isActive();
        });
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof GetNavigationCategoriesCommand;
    }
}
