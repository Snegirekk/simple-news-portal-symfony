<?php

namespace App\CommandBus\Command;

use App\Search\Search;

class GetEditableCategoryDataCommand
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
     * @return GetEditableCategoryDataCommand
     */
    public function setSearch(Search $search): self
    {
        $this->search = $search;
        return $this;
    }
}
