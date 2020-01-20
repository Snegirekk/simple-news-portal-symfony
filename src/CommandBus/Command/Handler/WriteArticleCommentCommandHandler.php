<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\WriteArticleCommentCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Entity\Article;
use App\Entity\ArticleComment;
use Doctrine\ORM\EntityManagerInterface;

class WriteArticleCommentCommandHandler implements CommandHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * WriteCategoryCommandHandler constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param WriteArticleCommentCommand $command
     * @return void
     */
    public function exec($command): void
    {
        $data = $command->getData();

        $article = $this->entityManager->getRepository(Article::class)->findOneBy(['slug' => $data->getArticleSlug()]);

        $articleComment = new ArticleComment();
        $articleComment
            ->setContent($data->getContent())
            ->setArticle($article);

        $this->entityManager->persist($articleComment);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof WriteArticleCommentCommand;
    }
}
