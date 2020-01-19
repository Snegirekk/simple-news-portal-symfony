<?php

namespace App\Dto\Article;

use App\Dto\DtoInterface;

class EditableArticleDto implements DtoInterface
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
     * @var string|null
     */
    private $announcement;

    /**
     * @var string|null
     */
    private $content;

    /**
     * @var bool
     */
    private $isActive = true;

    /**
     * @var int|null
     */
    private $categoryId;

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
     * @return EditableArticleDto
     */
    public function setId(?int $id): EditableArticleDto
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
     * @return EditableArticleDto
     */
    public function setTitle(?string $title): EditableArticleDto
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnnouncement(): ?string
    {
        return $this->announcement;
    }

    /**
     * @param string|null $announcement
     *
     * @return EditableArticleDto
     */
    public function setAnnouncement(?string $announcement): EditableArticleDto
    {
        $this->announcement = $announcement;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     *
     * @return EditableArticleDto
     */
    public function setContent(?string $content): EditableArticleDto
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return EditableArticleDto
     */
    public function setIsActive(bool $isActive): EditableArticleDto
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * @param int|null $categoryId
     *
     * @return EditableArticleDto
     */
    public function setCategoryId(?int $categoryId): EditableArticleDto
    {
        $this->categoryId = $categoryId;
        return $this;
    }
}
