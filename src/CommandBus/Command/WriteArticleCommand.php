<?php

namespace App\CommandBus\Command;

use App\Dto\Article\EditableArticleDto;

class WriteArticleCommand
{
    /**
     * @var EditableArticleDto
     */
    private $data;

    /**
     * @return EditableArticleDto
     */
    public function getData(): EditableArticleDto
    {
        return $this->data;
    }

    /**
     * @param EditableArticleDto $data
     *
     * @return WriteArticleCommand
     */
    public function setData(EditableArticleDto $data): WriteArticleCommand
    {
        $this->data = $data;
        return $this;
    }
}
