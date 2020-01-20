<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\GetEditableArticleDataCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Dto\Article\EditableArticleDto;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityNotFoundException;

class GetEditableArticleDataCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * WriteArticleHandler constructor.
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param GetEditableArticleDataCommand $command
     *
     * @return EditableArticleDto
     *
     * @throws EntityNotFoundException
     */
    public function exec($command): EditableArticleDto
    {
        $filters = $command->getSearch()->getFilters();

        /** @var Article $article */
        $article = $this->articleRepository->findOneBy($filters);

        if (!$article) {
            // todo: replace with some proper exception
            throw EntityNotFoundException::fromClassNameAndIdentifier(Article::class, $filters);
        }

        $articleDto = new EditableArticleDto();
        $articleDto
            ->setId($article->getId())
            ->setTitle($article->getTitle())
            ->setAnnouncement($article->getAnnouncement())
            ->setContent($article->getContent())
            ->setIsActive($article->isActive())
            ->setCategoryId($article->getCategory()->getId());

        return $articleDto;
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof GetEditableArticleDataCommand;
    }
}
