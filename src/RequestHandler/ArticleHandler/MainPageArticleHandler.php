<?php

namespace App\RequestHandler\ArticleHandler;

use App\Dto\AbstractDto;
use App\Dto\CollectionDto;
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
     */
    public function readPage(): PageDto
    {
        $collection = new CollectionDto(MainPageArticleDto::class);
        $pagination = $this->operation->getPagination();

        if (!$pagination) {
            throw RequestHandlerException::unsatisfiedRequirement($this->operation, 'pagination is required to read the page');
        }

        $articlesPaginator = $this->articleRepository->getArticlesForMainPage($pagination);

        foreach ($articlesPaginator as $article) {
            $articleDto = new MainPageArticleDto();
            $articleDto
                ->setTitle($article['title'])
                ->setAnnouncement($article['announcement'])
                ->setUrl($article['slug']);

            $collection->add($articleDto);
        }

        return new PageDto($collection, $pagination->getPage(), $pagination->getItemsPerPage());
    }

    /**
     * @inheritDoc
     */
    public function supports(string $dataType): bool
    {
        return $dataType === MainPageArticleDto::class;
    }
}