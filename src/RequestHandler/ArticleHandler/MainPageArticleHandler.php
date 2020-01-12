<?php

namespace App\RequestHandler\ArticleHandler;

use App\Dto\AbstractDto;
use App\Dto\CollectionDto;
use App\Dto\CollectionDtoInterface;
use App\Dto\PageDto;
use App\Repository\ArticleRepository;
use App\RequestHandler\ReadRequestHandlerInterface;
use App\Dto\Article\MainPageArticleDto;
use App\RequestHandler\AbstractRequestHandler;
use App\RequestHandler\RequestHandlerException;
use OutOfBoundsException;

class MainPageArticleHandler extends AbstractRequestHandler implements ReadRequestHandlerInterface
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * MainPageArticleProvider constructor.
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @inheritDoc
     * @throws RequestHandlerException
     */
    public function read(): AbstractDto
    {
        throw RequestHandlerException::unimplementedAction($this->operation, __FUNCTION__);
    }

    /**
     * @inheritDoc
     * @throws RequestHandlerException
     * @throws OutOfBoundsException
     * @return PageDto
     */
    public function readBatch(): CollectionDtoInterface
    {
        $collection = new CollectionDto(MainPageArticleDto::class);
        $pagination = $this->operation->getPagination();

        if (!$pagination) {
            throw RequestHandlerException::unsatisfiedRequirement($this->operation, 'pagination is required to read the page');
        }

        $articlesPaginator = $this->articleRepository->getArticlesForMainPage($pagination, $this->operation->getSearch());

        foreach ($articlesPaginator as $article) {
            $articleDto = new MainPageArticleDto();
            $articleDto
                ->setTitle($article['title'])
                ->setAnnouncement($article['announcement'])
                ->setSlug($article['slug']);

            $collection->add($articleDto);
        }

        $totalPages = ceil($articlesPaginator->count() / $pagination->getItemsPerPage());

        return new PageDto($collection, $pagination->getPage(), $pagination->getItemsPerPage(), $totalPages);
    }

    /**
     * @inheritDoc
     */
    public function supports(string $dataType): bool
    {
        return $dataType === MainPageArticleDto::class;
    }
}