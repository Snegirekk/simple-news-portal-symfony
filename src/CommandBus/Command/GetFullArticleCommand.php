<?php

namespace App\CommandBus\Command;

use App\Search\Search;

class GetFullArticleCommand
{
    /**
     * @var Search
     */
    private $search;

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
     * @return GetFullArticleCommand
     */
    public function setSearch(Search $search): GetFullArticleCommand
    {
        $this->search = $search;
        return $this;
    }
}
