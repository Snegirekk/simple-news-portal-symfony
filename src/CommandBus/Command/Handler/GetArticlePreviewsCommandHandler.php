<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\GetArticlePreviewsCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Dto\Article\PreviewArticleDto;
use App\Dto\CollectionDto;
use App\Dto\CollectionDtoInterface;
use App\Dto\PageDto;
use App\Repository\ArticleRepository;

class GetArticlePreviewsCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * MainPageArticleProvider constructor.
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param GetArticlePreviewsCommand $command
     *
     * @return CollectionDtoInterface
     */
    public function exec($command): CollectionDtoInterface
    {
        $collection = new CollectionDto(PreviewArticleDto::class);
        $pagination = $command->getPagination();

        $articlesPaginator = $this->articleRepository->getArticlePreviewsPage($pagination, $command->getSearch());

        foreach ($articlesPaginator as $article) {
            $articleDto = new PreviewArticleDto();
            $articleDto
                ->setTitle($article['title'])
                ->setAnnouncement($article['announcement'])
                ->setSlug($article['slug']);

            $collection->add($articleDto);
        }

        $totalPages = max(ceil($articlesPaginator->count() / $pagination->getItemsPerPage()), 1);

        return new PageDto($collection, $pagination->getPage(), $pagination->getItemsPerPage(), $totalPages);
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof GetArticlePreviewsCommand;
    }
}
