<?php

namespace App\Controller;

use App\CommandBus\Command\GetFullArticleCommand;
use App\CommandBus\Command\GetArticlePreviewsCommand;
use App\CommandBus\CommandBusInterface;
use App\Dto\Article\PreviewArticleDto;
use App\Dto\Article\ViewArticleDto;
use App\Dto\PageDto;
use App\Pagination\Pagination;
use App\Repository\CategoryRepository;
use App\Search\OrderByCondition;
use App\Search\Search;
use OutOfBoundsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends BaseController
{
    private const ITEMS_PER_PAGE = 3;

    private const SORT_CREATED_ASC = 'createdAt_asc';
    private const SORT_CREATED_DESC = 'createdAt_desc';

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * ArticleController constructor.
     *
     * @param CommandBusInterface $commandBus
     * @param CategoryRepository  $categoryRepository
     */
    public function __construct(CommandBusInterface $commandBus, CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

        parent::__construct($commandBus);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route(name="index", path="/", methods={"GET"})
     */
    public function listArticles(Request $request): Response
    {
        $command = new GetArticlePreviewsCommand();

        $page = $request->query->getInt('page', 1);
        $itemsPerPage = $request->query->getInt('itemsPerPage', self::ITEMS_PER_PAGE);
        $sort = $request->query->get('sort', self::SORT_CREATED_ASC);
        $categoryId = $request->query->getInt('category');

        $pagination = new Pagination($page, $itemsPerPage);
        $command->setPagination($pagination);

        if (!in_array($sort, [self::SORT_CREATED_ASC, self::SORT_CREATED_DESC])) {
            $sort = self::SORT_CREATED_ASC;
        }

        $orderBy = substr($sort, 0, strpos($sort, '_'));
        $direction = strtoupper(substr($sort, strrpos($sort, '_') + 1));

        $filters = ['isActive' => true];

        if ($categoryId) {
            $filters['category'] = $categoryId;
        }

        $search = new Search();
        $search
            ->setFilters($filters)
            ->addOrderBy(new OrderByCondition($orderBy, $direction));

        $command->setSearch($search);

        try {
            /** @var PageDto|PreviewArticleDto[] $articlesPageDto */
            $articlesPageDto = $this->commandBus->exec($command);
        } catch (OutOfBoundsException $exception) {
            throw new NotFoundHttpException(sprintf('Page %d not found.', $page));
        }

        return $this->render('index.html.twig', [
            'articlesPage' => $articlesPageDto,
        ]);
    }

    /**
     * @param string $slug
     *
     * @return Response
     *
     * @Route(name="view_article", path="/news/{slug}", methods={"GET"})
     */
    public function viewArticle(string $slug): Response
    {
        $search = new Search();
        $search->setFilters([
            'isActive' => true,
            'slug' => $slug,
        ]);

        $command = new GetFullArticleCommand();
        $command->setSearch($search);

        /** @var ViewArticleDto $articleDto */
        $articleDto = $this->commandBus->exec($command);

        return $this->render('article/view_article.html.twig', [
            'article' => $articleDto,
        ]);
    }
}
