<?php

namespace App\Controller;

use App\CommandBus\Command\DeleteCategoryCommand;
use App\CommandBus\Command\GetEditableCategoryDataCommand;
use App\CommandBus\Command\WriteCategoryCommand;
use App\CommandBus\CommandBusInterface;
use App\Dto\Category\CategoryIdDto;
use App\Dto\Category\EditableCategoryDto;
use App\Dto\DtoInterface;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use App\Search\Search;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends BaseController
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
     * @param Request $request
     *
     * @return Response
     *
     * @Route(name="create_category", path="/admin/categories/create", methods={"GET", "POST"})
     */
    public function createCategory(Request $request): Response
    {
        $form = $this->getCategoryForm($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $this->writeCategory($form->getData());
            return $this->redirectToRoute('edit_category', ['id' => $category->getId()]);
        }

        return $this->render('edit_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     *
     * @Route(name="edit_category", path="/admin/categories/edit/{id}", methods={"GET", "POST"})
     */
    public function editCategory(Request $request, int $id): Response
    {
        $search = new Search();
        $search->setFilters(['id' => $id]);

        $command = new GetEditableCategoryDataCommand();
        $command->setSearch($search);

        /** @var EditableCategoryDto $categoryDto */
        $categoryDto = $this->commandBus->exec($command);

        $form = $this->getCategoryForm($request, $categoryDto);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->writeCategory($form->getData());
        }

        return $this->render('edit_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param int $id
     *
     * @return Response
     *
     * @Route(name="delete_category", path="/admin/categories/delete/{id}", methods={"POST"})
     */
    public function deleteCategory(int $id): Response
    {
        $categoryDto = new CategoryIdDto();
        $categoryDto->setId($id);

        $command = new DeleteCategoryCommand();
        $command->setData($categoryDto);

        $this->commandBus->exec($command);

        return $this->redirectToRoute('index');
    }

    /**
     * @param Request                  $request
     * @param EditableCategoryDto|null $categoryDto
     *
     * @return FormInterface
     */
    private function getCategoryForm(Request $request, ?EditableCategoryDto $categoryDto = null): FormInterface
    {
        $categories = $this->categoryRepository->findCategoriesForChoice($excluded = [$categoryDto->getId()]);
        $categories = array_combine(array_column($categories, 'name'), array_column($categories, 'id'));

        $form = $this->createForm(CategoryFormType::class, $categoryDto, [
            'categories' => $categories,
        ]);

        $form->handleRequest($request);

        return $form;
    }

    /**
     * @param EditableCategoryDto $categoryDto
     *
     * @return CategoryIdDto|DtoInterface
     */
    private function writeCategory(EditableCategoryDto $categoryDto): CategoryIdDto
    {
        $command = new WriteCategoryCommand();
        $command->setData($categoryDto);

        return $this->commandBus->exec($command);
    }
}
