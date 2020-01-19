<?php

namespace App\Repository;

use App\Entity\Article;
use App\Pagination\Pagination;
use App\Pagination\PaginatorAwareTrait;
use App\Search\Search;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ArticleRepository extends BaseEntityRepository
{
    use PaginatorAwareTrait;

    /**
     * @param Pagination $pagination
     * @param Search     $search
     *
     * @return Paginator
     */
    public function getArticlesForMainPage(Pagination $pagination, Search $search): Paginator
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a.title, a.announcement, a.slug');

        foreach ($search->getFilters() as $field => $value) {
            $qb
                ->andWhere(sprintf('a.%1$s = :%1$s', $field))
                ->setParameter($field, $value);
        }

        foreach ($search->getOrderBy() as $orderByCondition) {
            $qb->addOrderBy('a.' . $orderByCondition->getField(), $orderByCondition->getDirection());
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
        return Article::class;
    }
}
