<?php

namespace App\CommandBus\Command;

use App\Pagination\Pagination;
use App\Search\Search;

class GetCategoriesPageCommand
{
    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * @var Search
     */
    private $search;

    /**
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    /**
     * @param Pagination $pagination
     *
     * @return GetCategoriesPageCommand
     */
    public function setPagination(Pagination $pagination): GetCategoriesPageCommand
    {
        $this->pagination = $pagination;
        return $this;
    }

    /**
     * @return Search
     */
    public function getSearch(): Search
    {
        return $this->search;
    }

    /**
     * @param Search $search
     *
     * @return GetCategoriesPageCommand
     */
    public function setSearch(Search $search): GetCategoriesPageCommand
    {
        $this->search = $search;
        return $this;
    }
}
