<?php

namespace App\Pagination;

class Pagination
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * Pagination constructor.
     *
     * @param int $page
     * @param int $itemsPerPage
     */
    public function __construct(int $page, int $itemsPerPage)
    {
        $this->page = $page;
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }
}
