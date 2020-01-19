<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleCommentRepository")
 * @ORM\Table(name="comments")
 */
class ArticleComment
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
     * @ORM\Column(type="text", nullable=false)
     */
    private $content;

    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $article;

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
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param Article $article
     *
     * @return self
     */
    public function setArticle(Article $article): self
    {
        $this->article = $article;
        return $this;
    }
}
