<?php

namespace App\Dto\Article;

use App\Dto\AbstractDto;

class ArticleSlugDto extends AbstractDto
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
     * @return ArticleSlugDto
     */
    public function setSlug(string $slug): ArticleSlugDto
    {
        $this->slug = $slug;
        return $this;
    }

}