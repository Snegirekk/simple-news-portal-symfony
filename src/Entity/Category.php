<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 */
class Category
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
    private $name;

    /**
     * @var Category|null
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $parent;

    /**
     * @var Article[]|Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     */
    private $articles;

    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Category|null
     */
    public function getParent(): ?Category
    {
        return $this->parent;
    }

    /**
     * @param Category|null $parent
     *
     * @return self
     */
    public function setParent(?Category $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Article[]|Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     *
     * @return Category
     */
    public function addArticle(Article $article): self
    {
        $this->articles->add($article);
        $article->setCategory($this);

        return $this;
    }

    /**
     * @param Article $article
     *
     * @return Category
     */
    public function removeArticle(Article $article): self
    {
        $this->articles->removeElement($article);
        $article->setCategory(null);

        return $this;
    }
}
