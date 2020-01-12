<?php

namespace App\Controller;

use App\Dto\Article\ArticleSlugDto;
use App\Dto\Article\DeleteArticleDto;
use App\Dto\Article\ViewArticleDto;
use App\Dto\Article\WriteableArticleDto;
use App\Form\ArticleFormType;
use App\Repository\CategoryRepository;
use App\RequestHandler\Operation\ReadOperation;
use App\RequestHandler\Operation\WriteOperation;
use App\RequestHandler\ReadRequestHandlerInterface;
use App\RequestHandler\RequestHandlerLocatorInterface;
use App\RequestHandler\WriteRequestHandlerInterface;
use App\Search\Search;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends BaseController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * ArticleController constructor.
     * @param RequestHandlerLocatorInterface $requestHandlerLocator
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(RequestHandlerLocatorInterface $requestHandlerLocator, CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

        parent::__construct($requestHandlerLocator);
    }

    /**
     * @param string $slug
     * @return Response
     *
     * @Route(name="view_article", path="/news/{slug}", methods={"GET"})
     */
    public function viewArticle(string $slug): Response
    {
        $search = new Search();
        $search->setFilters([
            'isActive' => true,
            'slug'     => $slug,
        ]);

        $operation = new ReadOperation(ViewArticleDto::class);
        $operation->setSearch($search);

        /** @var ReadRequestHandlerInterface $requestHandler */
        $requestHandler = $this->requestHandlerLocator->getRequestHandler($operation);
        $articleDto     = $requestHandler->read();

        return $this->render('view_article.html.twig', [
            'articleDto' => $articleDto,
        ]);
    }

    /**
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @return Response
     *
     * @Route(name="create_article", path="/admin/news/create", methods={"GET", "POST"})
     */
    public function createArticle(Request $request, CategoryRepository $categoryRepository): Response
    {
        $form = $this->getArticleForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $this->writeArticle($form->getData());
            return $this->redirectToRoute('edit_article', ['slug' => $article->getSlug()]);
        }

        return $this->render('create_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return Response
     *
     * @Route(name="edit_article", path="/admin/news/edit/{slug}", methods={"GET", "POST"})
     */
    public function editArticle(Request $request, string $slug): Response
    {
        $search = new Search();
        $search->setFilters(['slug' => $slug]);

        $operation = new ReadOperation(WriteableArticleDto::class);
        $operation->setSearch($search);

        /** @var ReadRequestHandlerInterface $requestHandler */
        $requestHandler = $this->requestHandlerLocator->getRequestHandler($operation);
        $articleDto     = $requestHandler->read();

        $form = $this->getArticleForm($request, $articleDto);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->writeArticle($form->getData());
        }

        return $this->render('create_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return Response
     *
     * @Route(name="delete_article", path="/admin/news/delete/{slug}", methods={"POST"})
     */
    public function deleteArticle(Request $request, string $slug): Response
    {
        $operation  = new WriteOperation(DeleteArticleDto::class);
        $articleDto = new DeleteArticleDto();
        $articleDto->setSlug($slug);

        /** @var WriteRequestHandlerInterface $requestHandler */
        $requestHandler = $this->requestHandlerLocator->getRequestHandler($operation);
        $requestHandler->delete($articleDto);

        return $this->redirectToRoute('index');
    }

    /**
     * @param Request $request
     * @param WriteableArticleDto|null $articleDto
     * @return FormInterface
     */
    private function getArticleForm(Request $request, ?WriteableArticleDto $articleDto = null): FormInterface
    {
        $categories = $this->categoryRepository->findCategoriesForChoice();
        $categories = array_combine(array_column($categories, 'name'), array_column($categories, 'id'));

        $form = $this->createForm(ArticleFormType::class, $articleDto, [
            'categories' => $categories,
        ]);

        $form->handleRequest($request);

        return $form;
    }

    /**
     * @param WriteableArticleDto $articleDto
     * @return ArticleSlugDto
     */
    private function writeArticle(WriteableArticleDto $articleDto): ArticleSlugDto
    {
        $operation = new WriteOperation(WriteableArticleDto::class);

        /** @var WriteRequestHandlerInterface $requestHandler */
        $requestHandler = $this->requestHandlerLocator->getRequestHandler($operation);

        return $requestHandler->write($articleDto);
    }
}