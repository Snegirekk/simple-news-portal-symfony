<?php

namespace App\Pagination;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use OutOfBoundsException;

trait PaginatorAwareTrait
{
    /**
     * @param Query      $query
     * @param Pagination $pagination
     * @param bool       $fetchJoinCollection
     *
     * @throws OutOfBoundsException
     *
     * @return Paginator
     */
    protected function getPaginator(Query $query, Pagination $pagination, bool $fetchJoinCollection = true): Paginator
    {
        $page = $pagination->getPage();
        $itemsPerPage = $pagination->getItemsPerPage();
        $firstResult = abs(($page - 1) * $itemsPerPage);

        $query
            ->setFirstResult($firstResult)
            ->setMaxResults($itemsPerPage);

        $paginator = new Paginator($query, $fetchJoinCollection);
        $paginator->setUseOutputWalkers(false);

        $lastPage = max(ceil($paginator->count() / $itemsPerPage), 1);

        if ($page < 1 || $page > $lastPage) {
            throw new OutOfBoundsException(sprintf('%d is out of available pages range: 1..%d', $page, $lastPage));
        }

        $paginator->setUseOutputWalkers(true);

        return $paginator;
    }
}
