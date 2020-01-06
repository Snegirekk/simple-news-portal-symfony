<?php

namespace App\Dto;

use IteratorAggregate;

interface CollectionDtoInterface extends IteratorAggregate
{
    /**
     * @return string
     */
    public function getItemsType(): string;
}