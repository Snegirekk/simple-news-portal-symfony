<?php

namespace App\RequestHandler\ArticleHandler;

use App\Dto\AbstractDto;
use App\Dto\Article\ViewArticleDto;
use App\Dto\ArticleComment\CommentDto;
use App\Dto\CollectionDtoInterface;
use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Repository\ArticleCommentRepository;
use App\Repository\ArticleRepository;
use App\RequestHandler\AbstractRequestHandler;
use App\RequestHandler\ReadRequestHandlerInterface;
use App\RequestHandler\RequestHandlerException;
use Doctrine\ORM\EntityNotFoundException;

class FullArticleHandler extends AbstractRequestHandler implements ReadRequestHandlerInterface
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var ArticleCommentRepository
     */
    private $articleCommentRepository;

    /**
     * FullArticleHandler constructor.
     * @param ArticleRepository $articleRepository
     * @param ArticleCommentRepository $articleCommentRepository
     */
    public function __construct(ArticleRepository $articleRepository, ArticleCommentRepository $articleCommentRepository)
    {
        $this->articleRepository        = $articleRepository;
        $this->articleCommentRepository = $articleCommentRepository;
    }

    /**
     * @inheritDoc
     */
    public function read(): AbstractDto
    {
        $filters = $this->operation->getSearch()->getFilters();

        /** @var Article $article */
        $article = $this->articleRepository->findOneBy($filters);

        if (!$article) {
            // todo: replace with some proper exception
            throw EntityNotFoundException::fromClassNameAndIdentifier(Article::class, $filters);
        }

        /** @var ArticleComment[] $comments */
        $comments    = $this->articleCommentRepository->findBy(['article' => $article]);
        $commentDtos = [];

        foreach ($comments as $comment) {
            $commentDto = new CommentDto();
            $commentDto->setContent($comment->getContent());

            $commentDtos[] = $commentDto;
        }

        $articleDto = new ViewArticleDto();
        $articleDto
            ->setTitle($article->getTitle())
            ->setContent($article->getContent())
            ->setComments($commentDtos)
            ->setCreatedAt($article->getCreatedAt());

        return $articleDto;
    }

    /**
     * @inheritDoc
     */
    public function readBatch(): CollectionDtoInterface
    {
        throw RequestHandlerException::unimplementedAction($this->operation, __FUNCTION__);
    }

    /**
     * @inheritDoc
     */
    public function supports(string $dataType): bool
    {
        return $dataType === ViewArticleDto::class;
    }
}