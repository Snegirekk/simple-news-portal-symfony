<?php

namespace App\Dto\Article;

use App\Dto\DtoInterface;

class PreviewArticleDto implements DtoInterface
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
     *
     * @return PreviewArticleDto
     */
    public function setTitle(string $title): PreviewArticleDto
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
     *
     * @return PreviewArticleDto
     */
    public function setAnnouncement(string $announcement): PreviewArticleDto
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
     *
     * @return PreviewArticleDto
     */
    public function setSlug(string $slug): PreviewArticleDto
    {
        $this->slug = $slug;
        return $this;
    }
}
