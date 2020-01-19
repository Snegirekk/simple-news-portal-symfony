<?php

namespace App\Search;

class Search
{
    /**
     * @var array
     */
    private $filters = [];

    /**
     * @var OrderByCondition[]
     */
    private $orderBy = [];

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     *
     * @return Search
     */
    public function setFilters(array $filters): Search
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * @return OrderByCondition[]
     */
    public function getOrderBy(): array
    {
        return $this->orderBy;
    }

    /**
     * @param OrderByCondition $orderBy
     *
     * @return Search
     */
    public function addOrderBy(OrderByCondition $orderBy): Search
    {
        $this->orderBy[] = $orderBy;
        return $this;
    }
}
