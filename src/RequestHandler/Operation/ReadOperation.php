<?php

namespace App\RequestHandler\Operation;

use App\Pagination\Pagination;
use App\Search\Search;

class ReadOperation extends Operation
{
    /**
     * @var Pagination|null
     */
    private $pagination;

    /**
     * @var Search|null
     */
    private $search;

    /**
     * @return Pagination|null
     */
    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

    /**
     * @param Pagination|null $pagination
     * @return ReadOperation
     */
    public function setPagination(?Pagination $pagination): ReadOperation
    {
        $this->pagination = $pagination;
        return $this;
    }

    /**
     * @return Search|null
     */
    public function getSearch(): ?Search
    {
        return $this->search;
    }

    /**
     * @param Search|null $search
     * @return ReadOperation
     */
    public function setSearch(?Search $search): ReadOperation
    {
        $this->search = $search;
        return $this;
    }

}