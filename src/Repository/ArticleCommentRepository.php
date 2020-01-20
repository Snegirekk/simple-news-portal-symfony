<?php

namespace App\Repository;

use App\Entity\ArticleComment;

class ArticleCommentRepository extends BaseEntityRepository
{
    /**
     * @inheritDoc
     */
    protected function getEntityClass(): string
    {
        return ArticleComment::class;
    }
}
