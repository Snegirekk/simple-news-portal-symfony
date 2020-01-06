<?php

namespace App\Dto;

use Countable;
use InvalidArgumentException;

class CollectionDto extends AbstractDto implements CollectionDtoInterface, FillableDtoInterface, Countable
{
    /**
     * @var AbstractDto[]
     */
    private $items = [];

    /**
     * @var string
     */
    private $itemsType;

    /**
     * PageDto constructor.
     * @param string $itemsType
     */
    public function __construct(string $itemsType)
    {
        $this->itemsType = $itemsType;
    }

    /**
     * @return string
     */
    public function getItemsType(): string
    {
        return $this->itemsType;
    }

    /**
     * @inheritDoc
     */
    public function add(AbstractDto $item): FillableDtoInterface
    {
        if (!$item instanceof $this->itemsType) {
            throw new InvalidArgumentException(sprintf('Can not add "%s" to collection of type "%s".', get_class($item), $this->itemsType));
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function remove(AbstractDto $item): FillableDtoInterface
    {
        $index = array_search($item, $this->items);

        if ($index) {
            unset($this->items[$index]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        foreach ($this->items as $i => $item) {
            yield $i => $item;
        }
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->items);
    }
}