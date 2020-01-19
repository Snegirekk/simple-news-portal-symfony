<?php

namespace App\CommandBus\Command;

use App\Dto\Category\CategoryIdDto;

class DeleteCategoryCommand
{
    /**
     * @var CategoryIdDto
     */
    private $data;

    /**
     * @return CategoryIdDto
     */
    public function getData(): CategoryIdDto
    {
        return $this->data;
    }

    /**
     * @param CategoryIdDto $data
     *
     * @return DeleteCategoryCommand
     */
    public function setData(CategoryIdDto $data): self
    {
        $this->data = $data;
        return $this;
    }
}
