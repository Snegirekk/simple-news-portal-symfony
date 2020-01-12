<?php

namespace App\Repository;

use App\Entity\Category;

class CategoryRepository extends BaseEntityRepository
{
    public function findCategoriesForChoice(): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.id, c.name');

        return $qb->getQuery()->getResult();
    }

    /**
     * @inheritDoc
     */
    protected function getEntityClass(): string
    {
        return Category::class;
    }
}
