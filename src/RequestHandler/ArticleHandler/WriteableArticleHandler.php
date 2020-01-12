<?php

namespace App\RequestHandler\ArticleHandler;

use App\Dto\AbstractDto;
use App\Dto\Article\ArticleSlugDto;
use App\Dto\Article\DeleteArticleDto;
use App\Dto\Article\WriteableArticleDto;
use App\Dto\CollectionDtoInterface;
use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\RequestHandler\AbstractRequestHandler;
use App\RequestHandler\ReadRequestHandlerInterface;
use App\RequestHandler\RequestHandlerException;
use App\RequestHandler\WriteRequestHandlerInterface;
use Cocur\Slugify\SlugifyInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\ORMException;

class WriteableArticleHandler extends AbstractRequestHandler implements WriteRequestHandlerInterface, ReadRequestHandlerInterface
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
     * WriteArticleHandler constructor.
     * @param ArticleRepository $articleRepository
     * @param EntityManagerInterface $entityManager
     * @param SlugifyInterface $slugifier
     */
    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, SlugifyInterface $slugifier)
    {
        $this->articleRepository = $articleRepository;
        $this->entityManager     = $entityManager;
        $this->slugifier         = $slugifier;
    }

    /**
     * @inheritDoc
     * @param WriteableArticleDto $data
     * @throws ORMException
     */
    public function write(AbstractDto $data): AbstractDto
    {
        $id   = $data->getId();
        $slug = $this->slugifier->slugify($data->getTitle()); // todo: check for non unique slug

        /** @var Article $article */
        $article = $id ? $this->entityManager->getReference(Article::class, $id) : new Article();
        $article
            ->setTitle($data->getTitle())
            ->setSlug($slug)
            ->setAnnouncement($data->getAnnouncement())
            ->setContent($data->getContent())
            ->setIsActive($data->isActive())
            ->setCategory($this->entityManager->getReference(Category::class, $data->getCategoryId()));

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
    public function writeBatch(iterable $data): AbstractDto
    {
        throw RequestHandlerException::unimplementedAction($this->operation, __FUNCTION__);
    }

    /**
     * @inheritDoc
     * @var DeleteArticleDto $data
     */
    public function delete(AbstractDto $data): void
    {
        $article = $this->articleRepository->findOneBy(['slug' => $data->getSlug()]);

        $this->entityManager->remove($article);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function deleteBatch(iterable $data): void
    {
        throw RequestHandlerException::unimplementedAction($this->operation, __FUNCTION__);
    }

    /**
     * @inheritDoc
     * @throws EntityNotFoundException
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

        $articleDto = new WriteableArticleDto();
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
    public function readBatch(): CollectionDtoInterface
    {
        throw RequestHandlerException::unimplementedAction($this->operation, __FUNCTION__);
    }

    /**
     * @inheritDoc
     */
    public function supports(string $dataType): bool
    {
        return in_array($dataType, [
            WriteableArticleDto::class,
            DeleteArticleDto::class,
        ]);
    }
}