<?php

namespace App\Dto\Article;

use App\Dto\AbstractDto;

class DeleteArticleDto extends AbstractDto
{
    /**
     * @var string
     */
    private $slug;

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return DeleteArticleDto
     */
    public function setSlug(string $slug): DeleteArticleDto
    {
        $this->slug = $slug;
        return $this;
    }

}