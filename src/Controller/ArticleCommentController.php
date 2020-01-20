<?php

namespace App\Controller;

use App\CommandBus\Command\WriteArticleCommentCommand;
use App\Dto\ArticleComment\CommentDto;
use App\Form\ArticleCommentForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleCommentController extends BaseController
{
    /**
     * @param Request $request
     * @param string  $slug
     *
     * @return Response
     *
     * @Route(name="post_article_comment", path="news/{slug}/post-comment", methods={"POST"})
     */
    public function postComment(Request $request, string $slug): Response
    {
        $form = $this->createForm(ArticleCommentForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CommentDto $data */
            $data = $form->getData();
            $data->setArticleSlug($slug);

            $command = new WriteArticleCommentCommand();
            $command->setData($data);

            $this->commandBus->exec($command);

            $this->redirectToRoute('view_article', ['slug' => $slug]);
        }

        return $this->forward(ArticleController::class . '::viewArticle', [
            'request' => $request,
            'slug' => $slug,
        ]);
    }
}
