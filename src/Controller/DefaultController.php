<?php

namespace App\Controller;

use App\Dto\Article\MainPageArticleDto;
use App\Dto\Category\NavigationCategoryDto;
use App\Dto\CollectionDtoInterface;
use App\Pagination\Pagination;
use App\RequestHandler\Operation\ReadOperation;
use App\RequestHandler\ReadRequestHandlerInterface;
use App\Search\OrderByCondition;
use App\Search\Search;
use OutOfBoundsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends BaseController
{
    private const ITEMS_PER_PAGE    = 3;
    private const SORT_CREATED_ASC  = 'createdAt_asc';
    private const SORT_CREATED_DESC = 'createdAt_desc';

    /**
     * @param Request $request
     * @return Response
     *
     * @Route(name="index", path="/", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $operation = new ReadOperation(MainPageArticleDto::class);

        $page         = $request->query->getInt('page', 1);
        $itemsPerPage = $request->query->getInt('itemsPerPage', self::ITEMS_PER_PAGE);
        $sort         = $request->query->get('sort', self::SORT_CREATED_ASC);
        $categoryId   = $request->query->getInt('category');

        $pagination = new Pagination($page, $itemsPerPage);
        $operation->setPagination($pagination);

        if (!in_array($sort, [self::SORT_CREATED_ASC, self::SORT_CREATED_DESC])) {
            $sort = self::SORT_CREATED_ASC;
        }

        $orderBy   = substr($sort, 0, strpos($sort, '_'));
        $direction = strtoupper(substr($sort, strrpos($sort, '_') + 1));

        $filters = ['isActive' => true];

        if ($categoryId) {
            $filters['category'] = $categoryId;
        }

        $search = new Search();
        $search
            ->setFilters($filters)
            ->addOrderBy(new OrderByCondition($orderBy, $direction));

        $operation->setSearch($search);

        /** @var ReadRequestHandlerInterface $requestHandler */
        $requestHandler = $this->requestHandlerLocator->getRequestHandler($operation);

        try {
            $articlesPageDto = $requestHandler->readBatch($pagination);
        } catch (OutOfBoundsException $exception) {
            throw new NotFoundHttpException(sprintf('Page %d not found.', $page));
        }

        return $this->render('index.html.twig', [
            'articlesPageDto' => $articlesPageDto,
            'categories'      => $this->getCategories(),
        ]);
    }

    /**
     * @return CollectionDtoInterface
     */
    private function getCategories(): CollectionDtoInterface
    {
        $operation = new ReadOperation(NavigationCategoryDto::class);

        /** @var ReadRequestHandlerInterface $requestHandler */
        $requestHandler = $this->requestHandlerLocator->getRequestHandler($operation);

        return $requestHandler->readBatch();
    }
}