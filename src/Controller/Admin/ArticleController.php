<?php

namespace App\Controller\Admin;

use App\CommandBus\Command\DeleteArticleCommand;
use App\CommandBus\Command\GetArticlePreviewsCommand;
use App\CommandBus\Command\GetEditableArticleDataCommand;
use App\CommandBus\Command\WriteArticleCommand;
use App\CommandBus\CommandBusInterface;
use App\Controller\BaseController;
use App\Dto\Article\ArticleSlugDto;
use App\Dto\Article\EditableArticleDto;
use App\Dto\Article\PreviewArticleDto;
use App\Dto\DtoInterface;
use App\Dto\PageDto;
use App\Form\ArticleFormType;
use App\Pagination\Pagination;
use App\Repository\CategoryRepository;
use App\Search\Search;
use OutOfBoundsException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends BaseController
{
    private const ITEMS_PER_PAGE = 10;

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route(name="admin", path="/admin", methods={"GET"})
     * @Route(name="admin.list_articles", path="/admin/news", methods={"GET"})
     */
    public function listArticles(Request $request): Response
    {
        $command = new GetArticlePreviewsCommand();

        $page = $request->query->getInt('page', 1);
        $itemsPerPage = $request->query->getInt('itemsPerPage', self::ITEMS_PER_PAGE);

        $pagination = new Pagination($page, $itemsPerPage);
        $command
            ->setSearch(new Search())
            ->setPagination($pagination);

        try {
            /** @var PageDto|PreviewArticleDto[] $articlesPageDto */
            $articlesPageDto = $this->commandBus->exec($command);
        } catch (OutOfBoundsException $exception) {
            throw new NotFoundHttpException(sprintf('Page %d not found.', $page));
        }

        return $this->render('article/admin_list_articles.html.twig', [
            'articlesPage' => $articlesPageDto,
        ]);
    }

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
     * @Route(name="create_article", path="/admin/news/create", methods={"GET", "POST"})
     */
    public function createArticle(Request $request): Response
    {
        $form = $this->getArticleForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $this->writeArticle($form->getData());
            return $this->redirectToRoute('edit_article', ['slug' => $article->getSlug()]);
        }

        return $this->render('article/edit_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param string  $slug
     *
     * @return Response
     *
     * @Route(name="edit_article", path="/admin/news/edit/{slug}", methods={"GET", "POST"})
     */
    public function editArticle(Request $request, string $slug): Response
    {
        $search = new Search();
        $search->setFilters(['slug' => $slug]);

        $command = new GetEditableArticleDataCommand();
        $command->setSearch($search);

        /** @var EditableArticleDto $articleDto */
        $articleDto = $this->commandBus->exec($command);

        $form = $this->getArticleForm($request, $articleDto);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->writeArticle($form->getData());
        }

        return $this->render('article/edit_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param string $slug
     *
     * @return Response
     *
     * @Route(name="delete_article", path="/admin/news/delete/{slug}", methods={"GET"})
     */
    public function deleteArticle(string $slug): Response
    {
        $articleDto = new ArticleSlugDto();
        $articleDto->setSlug($slug);

        $command = new DeleteArticleCommand();
        $command->setData($articleDto);

        $this->commandBus->exec($command);

        return $this->redirectToRoute('admin.list_articles');
    }

    /**
     * @param Request                 $request
     * @param EditableArticleDto|null $articleDto
     *
     * @return FormInterface
     */
    private function getArticleForm(Request $request, ?EditableArticleDto $articleDto = null): FormInterface
    {
        $categories = $this->categoryRepository->findCategoriesForChoice();
        $categories = array_combine(array_column($categories, 'title'), array_column($categories, 'id'));

        $form = $this->createForm(ArticleFormType::class, $articleDto, [
            'categories' => $categories,
        ]);

        $form->handleRequest($request);

        return $form;
    }

    /**
     * @param EditableArticleDto $articleDto
     *
     * @return ArticleSlugDto|DtoInterface
     */
    private function writeArticle(EditableArticleDto $articleDto): ArticleSlugDto
    {
        $command = new WriteArticleCommand();
        $command->setData($articleDto);

        return $this->commandBus->exec($command);
    }
}
