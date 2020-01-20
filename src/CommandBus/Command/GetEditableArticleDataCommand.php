<?php

namespace App\CommandBus\Command;

use App\Search\Search;

class GetEditableArticleDataCommand
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
     * @return GetEditableArticleDataCommand
     */
    public function setSearch(Search $search): GetEditableArticleDataCommand
    {
        $this->search = $search;
        return $this;
    }
}
