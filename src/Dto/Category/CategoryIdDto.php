<?php

namespace App\Dto\Category;

use App\Dto\DtoInterface;

class CategoryIdDto implements DtoInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return CategoryIdDto
     */
    public function setId(int $id): CategoryIdDto
    {
        $this->id = $id;
        return $this;
    }
}
