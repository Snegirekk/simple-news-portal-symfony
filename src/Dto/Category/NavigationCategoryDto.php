<?php

namespace App\Dto\Category;

use App\Dto\DtoInterface;

class NavigationCategoryDto implements DtoInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var NavigationCategoryDto[]
     */
    private $subcategories;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return NavigationCategoryDto
     */
    public function setId(int $id): NavigationCategoryDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return NavigationCategoryDto
     */
    public function setTitle(string $title): NavigationCategoryDto
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return NavigationCategoryDto[]
     */
    public function getSubcategories(): array
    {
        return $this->subcategories;
    }

    /**
     * @param NavigationCategoryDto[] $subcategories
     *
     * @return NavigationCategoryDto
     */
    public function setSubcategories(array $subcategories): NavigationCategoryDto
    {
        $this->subcategories = $subcategories;
        return $this;
    }
}
