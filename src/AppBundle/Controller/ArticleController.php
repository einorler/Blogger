<?php

namespace AppBundle\Controller;

use AppBundle\Document\Comment;
use ONGR\FilterManagerBundle\Tests\Functional\Filter\Widget\Pager\PagerTest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Document\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    public function documentAction(Request $request, Article $document)
    {
        $categories = $this->get('app.category_handler')->getCategories(
            $this->get('ongr_settings.settings_manager')->getCachedValue('content_disable_premium_categories'),
            $this->getUser()
        );

        return $this->render('default/article.html.twig', [
            'document' => $document,
            'categories' => $categories,
            'error' => $request->request->get('error')
        ]);
    }

    /**
     * @Route("/article/add-comment", name="commentAdd")
     */
    public function commentAddAction(Request $request)
    {
        $handler = $this->get('app.article_handler');
        $user = $this->getUser() ? $this->getUser()->getUsername() : 'anonymous';
        $article = $handler->getArticle($request->request->get('article'));
        $error = $handler->addComment($request, $article, $user);

        if ($error) {
            $request->request->set('error', $error);
            $request->server->set('REQUEST_URI', $article->getUrl());
            return $this->documentAction($request, $article);
        }

        return new RedirectResponse($article->getUrl());
    }

    /**
     * @Route("/article/like-comment", name="commentLike")
     */
    public function commentLikeAction(Request $request)
    {
        $handler = $this->get('app.article_handler');
        $article = $handler->getArticle($request->query->get('article'));

        foreach ($article->getComments() as $comment) {
            if ($comment->getNumber() == $request->query->get('comment')) {
                $comment->incrementLikes();

                break;
            }
        }

        $error = !$this->get('app.article_handler')->saveArticle($article);

        if ($error) {
            $request->request->set('error', $error);
            $request->server->set('REQUEST_URI', $article->getUrl());
            return $this->documentAction($request, $article);
        }

        return new RedirectResponse($article->getUrl());
    }
}
