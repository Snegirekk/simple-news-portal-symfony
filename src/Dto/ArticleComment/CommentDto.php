<?php

namespace App\Dto\ArticleComment;

use App\Dto\DtoInterface;

class CommentDto implements DtoInterface
{
    /**
     * @var string
     */
    private $content;

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
     * @return CommentDto
     */
    public function setContent(string $content): CommentDto
    {
        $this->content = $content;
        return $this;
    }
}
