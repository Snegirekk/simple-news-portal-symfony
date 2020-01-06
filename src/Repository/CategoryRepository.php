<?php

namespace App\Repository;

use App\Entity\Category;

class CategoryRepository extends BaseEntityRepository
{
    /**
     * @inheritDoc
     */
    protected function getEntityClass(): string
    {
        return Category::class;
    }
}
