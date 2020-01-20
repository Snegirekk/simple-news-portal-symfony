<?php

namespace App\Dto;

interface FillableDtoInterface extends DtoInterface
{
    /**
     * @param DtoInterface $item
     *
     * @return self
     */
    public function add(DtoInterface $item): self;

    /**
     * @param DtoInterface $item
     *
     * @return self
     */
    public function remove(DtoInterface $item): self;
}
