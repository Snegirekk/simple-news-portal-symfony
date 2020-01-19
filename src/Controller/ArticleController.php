<?php

namespace App\Controller;

use App\CommandBus\Command\DeleteArticleCommand;
use App\CommandBus\Command\GetEditableArticleDataCommand;
use App\CommandBus\Command\GetFullArticleCommand;
use App\CommandBus\Command\WriteArticleCommand;
use App\CommandBus\CommandBusInterface;
use App\Dto\Article\ArticleSlugDto;
use App\Dto\Article\EditableArticleDto;
use App\Dto\Article\ViewArticleDto;
use App\Dto\DtoInterface;
use App\Form\ArticleFormType;
use App\Repository\CategoryRepository;
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

        return $this->render('view_article.html.twig', [
            'article' => $articleDto,
        ]);
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

        return $this->render('edit_article.html.twig', [
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

        return $this->render('edit_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param string $slug
     *
     * @return Response
     *
     * @Route(name="delete_article", path="/admin/news/delete/{slug}", methods={"POST"})
     */
    public function deleteArticle(string $slug): Response
    {
        $articleDto = new ArticleSlugDto();
        $articleDto->setSlug($slug);

        $command = new DeleteArticleCommand();
        $command->setData($articleDto);

        $this->commandBus->exec($command);

        return $this->redirectToRoute('index');
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
        $categories = array_combine(array_column($categories, 'name'), array_column($categories, 'id'));

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
