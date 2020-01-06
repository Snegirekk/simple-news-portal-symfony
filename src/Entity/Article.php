<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @ORM\Table(name="articles")
 */
class Article
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint", options={"unsigned": true})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $announcement;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    private $content;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isActive = true;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $category;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return self
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnnouncement(): string
    {
        return $this->announcement;
    }

    /**
     * @param string $announcement
     * @return self
     */
    public function setAnnouncement(string $announcement): self
    {
        $this->announcement = $announcement;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return self
     */
    public function setContent(string $content): self
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
     * @return self
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return self
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return self
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

}