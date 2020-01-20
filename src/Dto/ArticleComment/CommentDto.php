<?php

namespace App\Dto\ArticleComment;

use App\Dto\DtoInterface;

class CommentDto implements DtoInterface
{
    /**
     * @var string|null
     */
    private $content;

    /**
     * @var string|null
     */
    private $articleSlug;

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
     * @return CommentDto
     */
    public function setContent(?string $content): CommentDto
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getArticleSlug(): ?string
    {
        return $this->articleSlug;
    }

    /**
     * @param string|null $articleSlug
     * @return CommentDto
     */
    public function setArticleSlug(?string $articleSlug): CommentDto
    {
        $this->articleSlug = $articleSlug;
        return $this;
    }
}
