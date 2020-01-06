<?php

namespace App\Controller;

use App\Dto\Article\MainPageArticleDto;
use App\Pagination\Pagination;
use App\RequestHandler\Operation\ReadOperation;
use App\RequestHandler\ReadRequestHandlerInterface;
use App\RequestHandler\RequestHandlerLocatorInterface;
use OutOfBoundsException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    private const MAIN_PAGE_ITEMS_PER_PAGE = 3;

    /**
     * @param Request $request
     * @param RequestHandlerLocatorInterface $requestHandlerLocator
     * @return Response
     *
     * @Route(name="index", path="/", methods={"GET"})
     */
    public function index(Request $request, RequestHandlerLocatorInterface $requestHandlerLocator): Response
    {
        $page         = $request->query->getInt('page', 1);
        $itemsPerPage = $request->query->getInt('itemsPerPage', self::MAIN_PAGE_ITEMS_PER_PAGE);

        $pagination = new Pagination($page, $itemsPerPage);

        $operation = new ReadOperation(MainPageArticleDto::class);
        $operation->setPagination($pagination);

        /** @var ReadRequestHandlerInterface $requestHandler */
        $requestHandler = $requestHandlerLocator->getRequestHandler($operation);

        try {
            $articlesPageDto = $requestHandler->readPage($pagination);
        } catch (OutOfBoundsException $exception) {
            throw new NotFoundHttpException(sprintf('Page %d not found.', $page));
        }

        return $this->render('index.html.twig', [
            'articlesPageDto' => $articlesPageDto,
        ]);
    }
}