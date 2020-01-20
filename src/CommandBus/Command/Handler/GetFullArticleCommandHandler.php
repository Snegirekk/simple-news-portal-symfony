<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\GetFullArticleCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Dto\Article\ViewArticleDto;
use App\Dto\ArticleComment\CommentDto;
use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Repository\ArticleCommentRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityNotFoundException;

class GetFullArticleCommandHandler implements CommandHandlerInterface
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
     *
     * @param ArticleRepository        $articleRepository
     * @param ArticleCommentRepository $articleCommentRepository
     */
    public function __construct(ArticleRepository $articleRepository, ArticleCommentRepository $articleCommentRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->articleCommentRepository = $articleCommentRepository;
    }

    /**
     * @param GetFullArticleCommand $command
     *
     * @return ViewArticleDto
     *
     * @throws EntityNotFoundException
     */
    public function exec($command): ViewArticleDto
    {
        $filters = $command->getSearch()->getFilters();

        /** @var Article $article */
        $article = $this->articleRepository->findOneBy($filters);

        if (!$article) {
            // todo: replace with some proper exception
            throw EntityNotFoundException::fromClassNameAndIdentifier(Article::class, $filters);
        }

        /** @var ArticleComment[] $comments */
        $comments = $this->articleCommentRepository->findBy(['article' => $article], ['id' => 'DESC']);
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
    public function supports($command): bool
    {
        return $command instanceof GetFullArticleCommand;
    }
}
