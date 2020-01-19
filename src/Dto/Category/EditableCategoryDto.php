<?php

namespace App\Dto\Category;

use App\Dto\DtoInterface;

class EditableCategoryDto implements DtoInterface
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @var int|null
     */
    private $parentCategoryId;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return EditableCategoryDto
     */
    public function setId(?int $id): EditableCategoryDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return EditableCategoryDto
     */
    public function setTitle(?string $title): EditableCategoryDto
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getParentCategoryId(): ?int
    {
        return $this->parentCategoryId;
    }

    /**
     * @param int|null $parentCategoryId
     *
     * @return EditableCategoryDto
     */
    public function setParentCategoryId(?int $parentCategoryId): EditableCategoryDto
    {
        $this->parentCategoryId = $parentCategoryId;
        return $this;
    }
}
