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
    private $url;

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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return MainPageArticleDto
     */
    public function setUrl(string $url): MainPageArticleDto
    {
        $this->url = $url;
        return $this;
    }

}