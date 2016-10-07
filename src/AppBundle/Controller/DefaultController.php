<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $categories = $this->get('app.category_handler')->getCategories(
            $this->get('ongr_settings.settings_manager')->getCachedValue('content_disable_premium_categories'),
            $this->getUser()
        );

        return $this->render('default/search.html.twig', [
            'categories' => $categories,
            'filters' => $this->get('ongr_filter_manager.article')->handleRequest($request),
        ]);
    }
}
