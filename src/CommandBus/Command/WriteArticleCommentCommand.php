<?php

namespace App\CommandBus\Command;

use App\Dto\ArticleComment\CommentDto;

class WriteArticleCommentCommand
{
    /**
     * @var CommentDto
     */
    private $data;

    /**
     * @return CommentDto
     */
    public function getData(): CommentDto
    {
        return $this->data;
    }

    /**
     * @param CommentDto $data
     *
     * @return WriteArticleCommentCommand
     */
    public function setData(CommentDto $data): WriteArticleCommentCommand
    {
        $this->data = $data;
        return $this;
    }
}
