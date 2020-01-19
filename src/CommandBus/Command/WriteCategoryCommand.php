<?php

namespace App\CommandBus\Command;

use App\Dto\Category\EditableCategoryDto;

class WriteCategoryCommand
{
    /**
     * @var EditableCategoryDto
     */
    private $data;

    /**
     * @return EditableCategoryDto
     */
    public function getData(): EditableCategoryDto
    {
        return $this->data;
    }

    /**
     * @param EditableCategoryDto $data
     *
     * @return WriteCategoryCommand
     */
    public function setData(EditableCategoryDto $data): WriteCategoryCommand
    {
        $this->data = $data;
        return $this;
    }
}
