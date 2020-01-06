<?php

namespace App\Dto;

interface FillableDtoInterface
{
    /**
     * @param AbstractDto $item
     * @return self
     */
    public function add(AbstractDto $item): self;

    /**
     * @param AbstractDto $item
     * @return self
     */
    public function remove(AbstractDto $item): self;
}