<?php

namespace App\Repository;

use App\Entity\Category;

class CategoryRepository extends BaseEntityRepository
{
    public function findCategoriesForChoice(?array $excluded = null): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c.id, c.name');

        if ($excluded && !empty($excluded)) {
            $qb->andWhere($qb->expr()->notIn('c', $excluded));
        }

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
