<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        return $this->render('default/admin.html.twig');
    }

    /**
     * @Route("/admin/new/article", name="newArticle")
     */
    public function newArticleAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/newArticle.html.twig', [
            'error' => false,
            'success' => false,
            'categories' => $this->get('app.category_handler')->getNameArray(),
        ]);
    }

    /**
     * @Route("/admin/handle/article", name="handleArticle")
     */
    public function handleArticleAction(Request $request)
    {
        $error = $this->get('app.article_handler')->addArticle($request);

        // replace this example code with whatever you need
        return $this->render('default/newArticle.html.twig', [
            'error' => $error,
            'success' => !$error,
            'categories' => $this->get('app.category_handler')->getNameArray(),
        ]);
    }
}
