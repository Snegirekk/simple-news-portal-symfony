<?php

namespace App\RequestHandler\CategoryHandler;

use App\Dto\AbstractDto;
use App\Dto\Category\NavigationCategoryDto;
use App\Dto\CollectionDto;
use App\Dto\CollectionDtoInterface;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\RequestHandler\AbstractRequestHandler;
use App\RequestHandler\ReadRequestHandlerInterface;
use App\RequestHandler\RequestHandlerException;

class CategoryHandler extends AbstractRequestHandler implements ReadRequestHandlerInterface
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryHandler constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @inheritDoc
     */
    public function read(): AbstractDto
    {
        throw RequestHandlerException::unimplementedAction($this->operation, __FUNCTION__);
    }

    /**
     * @inheritDoc
     */
    public function readBatch(): CollectionDtoInterface
    {
        /** @var Category[] $categories */
        $categories   = $this->categoryRepository->findBy(['parent' => null]);
        $categoryDtos = new CollectionDto(NavigationCategoryDto::class);

        foreach ($categories as $category) {
            $categoryDto = new NavigationCategoryDto();
            $categoryDto
                ->setId($category->getId())
                ->setTitle($category->getName());

            $this->setSubcategories($categoryDto);

            $categoryDtos->add($categoryDto);
        }

        return $categoryDtos;
    }

    /**
     * @inheritDoc
     */
    public function supports(string $dataType): bool
    {
        return $dataType === NavigationCategoryDto::class;
    }

    /**
     * @param NavigationCategoryDto $categoryDto
     */
    private function setSubcategories(NavigationCategoryDto $categoryDto): void
    {
        /** @var Category[] $subcategories */
        $subcategories   = $this->categoryRepository->findBy(['parent' => $categoryDto->getId()]);
        $subcategoryDtos = [];

        foreach ($subcategories as $subcategory) {
            $subcategoryDto = new NavigationCategoryDto();
            $subcategoryDto
                ->setId($subcategory->getId())
                ->setTitle($subcategory->getName());

            $this->setSubcategories($subcategoryDto);

            $subcategoryDtos[] = $subcategoryDto;
        }

        $categoryDto->setSubcategories($subcategoryDtos);
    }
}