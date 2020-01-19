<?php

namespace App\Repository;

use App\Entity\Category;
use App\Pagination\Pagination;
use App\Pagination\PaginatorAwareTrait;
use App\Search\Search;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryRepository extends BaseEntityRepository
{
    use PaginatorAwareTrait;

    /**
     * @param array|null $excluded
     * @return array
     */
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
     * @param Pagination $pagination
     * @param Search $search
     * @return Paginator
     */
    public function getCategoriesPage(Pagination $pagination, Search $search): Paginator
    {
        $qb = $this->createQueryBuilder('c');

        foreach ($search->getFilters() as $field => $value) {
            $qb
                ->andWhere(sprintf('c.%1$s = :%1$s', $field))
                ->setParameter($field, $value);
        }

        foreach ($search->getOrderBy() as $orderByCondition) {
            $qb->addOrderBy('c.' . $orderByCondition->getField(), $orderByCondition->getDirection());
        }

        $paginator = $this->getPaginator($qb->getQuery(), $pagination);
        $paginator->setUseOutputWalkers(false);

        return $paginator;
    }

    /**
     * @inheritDoc
     */
    protected function getEntityClass(): string
    {
        return Category::class;
    }
}
