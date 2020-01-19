<?php

namespace App\Dto;

interface CollectionDtoInterface extends DtoInterface
{
    /**
     * @return string
     */
    public function getItemsType(): string;
}
