<?php

namespace App\CommandBus\Command;

use App\Pagination\Pagination;
use App\Search\Search;

class GetMainPageArticlesCommand
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
     * @return GetMainPageArticlesCommand
     */
    public function setPagination(Pagination $pagination): GetMainPageArticlesCommand
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
     * @return GetMainPageArticlesCommand
     */
    public function setSearch(Search $search): GetMainPageArticlesCommand
    {
        $this->search = $search;
        return $this;
    }
}
