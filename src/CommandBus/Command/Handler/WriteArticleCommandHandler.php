<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\WriteArticleCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Dto\Article\ArticleSlugDto;
use App\Entity\Article;
use App\Entity\Category;
use Cocur\Slugify\SlugifyInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

class WriteArticleCommandHandler implements CommandHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SlugifyInterface
     */
    private $slugifier;

    /**
     * WriteArticleHandler constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param SlugifyInterface       $slugifier
     */
    public function __construct(EntityManagerInterface $entityManager, SlugifyInterface $slugifier)
    {
        $this->entityManager = $entityManager;
        $this->slugifier = $slugifier;
    }

    /**
     * @param WriteArticleCommand $command
     *
     * @return ArticleSlugDto
     *
     * @throws ORMException
     */
    public function exec($command): ArticleSlugDto
    {
        $data = $command->getData();

        $id = $data->getId();
        $slug = $this->slugifier->slugify($data->getTitle()); // todo: check for non unique slug

        /** @var Category $categoryReference */
        $categoryReference = $this->entityManager->getReference(Category::class, $data->getCategoryId());

        /** @var Article $article */
        $article = $id ? $this->entityManager->getReference(Article::class, $id) : new Article();
        $article
            ->setTitle($data->getTitle())
            ->setSlug($slug)
            ->setAnnouncement($data->getAnnouncement())
            ->setContent($data->getContent())
            ->setIsActive($data->isActive())
            ->setCategory($categoryReference);

        if (!$id) {
            $article->setCreatedAt(new DateTime());
        }

        $this->entityManager->persist($article);
        $this->entityManager->flush();

        $articleDto = new ArticleSlugDto();
        $articleDto->setSlug($slug);

        return $articleDto;
    }

    /**
     * @inheritDoc
     */
    public function supports($command): bool
    {
        return $command instanceof WriteArticleCommand;
    }
}
