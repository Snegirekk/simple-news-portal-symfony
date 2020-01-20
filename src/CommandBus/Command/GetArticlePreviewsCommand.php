<?php

namespace App\CommandBus\Command;

use App\Pagination\Pagination;
use App\Search\Search;

class GetArticlePreviewsCommand
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
     * @return GetArticlePreviewsCommand
     */
    public function setPagination(Pagination $pagination): GetArticlePreviewsCommand
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
     * @return GetArticlePreviewsCommand
     */
    public function setSearch(Search $search): GetArticlePreviewsCommand
    {
        $this->search = $search;
        return $this;
    }
}
