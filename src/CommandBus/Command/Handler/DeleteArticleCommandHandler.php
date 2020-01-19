<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\DeleteArticleCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteArticleCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * DeleteArticleCommandHandler constructor.
     *
     * @param ArticleRepository      $articleRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {
        $this->articleRepository = $articleRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param DeleteArticleCommand $command
     */
    public function exec($command): void
    {
        $data = $command->getData();

        $article = $this->articleRepository->findOneBy(['slug' => $data->getSlug()]);

        $this->entityManager->remove($article);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof DeleteArticleCommand;
    }
}
