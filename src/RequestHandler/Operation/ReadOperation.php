<?php

namespace App\RequestHandler\Operation;

use App\Pagination\Pagination;

class ReadOperation extends Operation
{
    /**
     * @var Pagination|null
     */
    private $pagination;

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

}