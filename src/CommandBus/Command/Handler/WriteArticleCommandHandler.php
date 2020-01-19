<?php

namespace App\CommandBus\Command\Handler;

use App\CommandBus\Command\WriteArticleCommand;
use App\CommandBus\CommandHandlerInterface;
use App\Dto\Article\ArticleSlugDto;
use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use Cocur\Slugify\SlugifyInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\ORMException;

class WriteArticleCommandHandler implements CommandHandlerInterface
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
     * @var SlugifyInterface
     */
    private $slugifier;

    /**
     * WriteArticleCommandHandler constructor.
     *
     * @param ArticleRepository      $articleRepository
     * @param EntityManagerInterface $entityManager
     * @param SlugifyInterface       $slugifier
     */
    public function __construct(
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManager,
        SlugifyInterface $slugifier
    ) {
        $this->articleRepository = $articleRepository;
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

        /** @var Category $categoryReference */
        $categoryReference = $this->entityManager->getReference(Category::class, $data->getCategoryId());
        $slug = $this->generateSlug($data->getTitle());

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

    /**
     * @param string $title
     *
     * @return string
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    private function generateSlug(string $title): string
    {
        $slug = $this->slugifier->slugify($title);
        $newSlug = $slug;

        $i = 0;
        while (!$this->articleRepository->isSlugAvailable($newSlug)) {
            $newSlug = $slug . '_' . ++$i;
        }

        return $newSlug;
    }
}
