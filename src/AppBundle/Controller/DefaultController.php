<?php

namespace AppBundle\Controller;

use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ONGR\ElasticsearchBundle\Collection\Collection;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function articlesAction(Request $request)
    {
        $categories = $this->get('app.category_handler')->getCategories(
            $this->get('ongr_settings.settings_manager')->getCachedValue('content_disable_premium_categories'),
            $this->getUser()
        );

        return $this->render('default/articles.html.twig', [
            'categories' => $categories
        ]);
    }

    private function deleteComments()
    {
        $repo = $this->get('es.manager.default.article');
        $articles = $repo->findDocuments(new Search(new MatchAllQuery()));

        foreach ($articles as $article) {
            if ($article->getComments()) {
                $article->setComments(new Collection());
                $repo->getManager()->persist($article);
            }
        }

        $repo->getManager()->commit();
    }
}
