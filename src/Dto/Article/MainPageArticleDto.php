<?php

namespace App\Dto\Article;

use App\Dto\AbstractDto;

class MainPageArticleDto extends AbstractDto
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $announcement;

    /**
     * @var string
     */
    private $slug;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return MainPageArticleDto
     */
    public function setTitle(string $title): MainPageArticleDto
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnnouncement(): string
    {
        return $this->announcement;
    }

    /**
     * @param string $announcement
     * @return MainPageArticleDto
     */
    public function setAnnouncement(string $announcement): MainPageArticleDto
    {
        $this->announcement = $announcement;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return MainPageArticleDto
     */
    public function setSlug(string $slug): MainPageArticleDto
    {
        $this->slug = $slug;
        return $this;
    }

}