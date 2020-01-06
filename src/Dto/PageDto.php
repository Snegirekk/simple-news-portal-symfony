<?php

namespace App\Dto;

use Countable;

class PageDto extends AbstractDto implements CollectionDtoInterface, Countable
{
    /**
     * @var CollectionDto
     */
    private $collection;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * @var int
     */
    private $totalPages;

    /**
     * PageDto constructor.
     * @param CollectionDto $collection
     * @param int $page
     * @param int $itemsPerPage
     */
    public function __construct(CollectionDto $collection, int $page, int $itemsPerPage)
    {
        $this->collection = $collection;
        $this->page = $page;
        $this->itemsPerPage = $itemsPerPage;
        $this->totalPages = (int)ceil($collection->count() / $itemsPerPage);
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

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @inheritDoc
     */
    public function getItemsType(): string
    {
        return $this->collection->getItemsType();
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return $this->collection->getIterator();
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return $this->collection->count();
    }
}