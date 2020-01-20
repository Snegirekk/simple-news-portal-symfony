<?php

namespace App\Repository;

use App\Entity\Article;
use App\Pagination\Pagination;
use App\Pagination\PaginatorAwareTrait;
use App\Search\Search;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
    public function getArticlePreviewsPage(Pagination $pagination, Search $search): Paginator
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
     * @param string $slug
     *
     * @return bool
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function isSlugAvailable(string $slug): bool
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('COUNT(1)')
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug);

        $found = (int) $qb->getQuery()->getSingleScalarResult();

        return $found === 0;
    }

    /**
     * @inheritDoc
     */
    protected function getEntityClass(): string
    {
        return Article::class;
    }
}
