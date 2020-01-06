<?php

namespace App\Repository;

use App\Entity\Article;
use App\Pagination\Pagination;
use App\Pagination\PaginatorAwareTrait;
use Doctrine\ORM\Tools\Pagination\Paginator;
use OutOfBoundsException;

class ArticleRepository extends BaseEntityRepository
{
    use PaginatorAwareTrait;

    /**
     * @param Pagination $pagination
     * @throws OutOfBoundsException
     * @return Paginator
     */
    public function getArticlesForMainPage(Pagination $pagination): Paginator
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('a.title, a.announcement, a.slug')
            ->andWhere('a.isActive = true');

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
