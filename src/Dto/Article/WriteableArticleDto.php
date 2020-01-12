<?php

namespace App\Dto\Article;

use App\Dto\AbstractDto;

class WriteableArticleDto extends AbstractDto
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
     * @return WriteableArticleDto
     */
    public function setId(?int $id): WriteableArticleDto
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
     * @return WriteableArticleDto
     */
    public function setTitle(?string $title): WriteableArticleDto
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
     * @return WriteableArticleDto
     */
    public function setAnnouncement(?string $announcement): WriteableArticleDto
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
     * @return WriteableArticleDto
     */
    public function setContent(?string $content): WriteableArticleDto
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
     * @return WriteableArticleDto
     */
    public function setIsActive(bool $isActive): WriteableArticleDto
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
     * @return WriteableArticleDto
     */
    public function setCategoryId(?int $categoryId): WriteableArticleDto
    {
        $this->categoryId = $categoryId;
        return $this;
    }

}