<?php

namespace App\CommandBus\Command;

use App\Dto\Article\ArticleSlugDto;

class DeleteArticleCommand
{
    /**
     * @var ArticleSlugDto
     */
    private $data;

    /**
     * @return ArticleSlugDto
     */
    public function getData(): ArticleSlugDto
    {
        return $this->data;
    }

    /**
     * @param ArticleSlugDto $data
     *
     * @return DeleteArticleCommand
     */
    public function setData(ArticleSlugDto $data): DeleteArticleCommand
    {
        $this->data = $data;
        return $this;
    }
}
