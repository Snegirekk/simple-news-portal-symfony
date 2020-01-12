<?php

namespace App\Dto\Article;

use App\Dto\AbstractDto;
use App\Dto\ArticleComment\CommentDto;
use DateTime;

class ViewArticleDto extends AbstractDto
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var CommentDto[]
     */
    private $comments;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return ViewArticleDto
     */
    public function setTitle(string $title): ViewArticleDto
    {
        $this->title = $title;
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
     * @return ViewArticleDto
     */
    public function setContent(string $content): ViewArticleDto
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return CommentDto[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param CommentDto[] $comments
     * @return ViewArticleDto
     */
    public function setComments(array $comments): ViewArticleDto
    {
        $this->comments = $comments;
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
     * @return ViewArticleDto
     */
    public function setCreatedAt(DateTime $createdAt): ViewArticleDto
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}