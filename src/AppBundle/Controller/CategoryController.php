<?php

namespace AppBundle\Controller;

use AppBundle\Document\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function documentAction(Request $request, Category $document)
    {
        $categories = $this->get('app.category_handler')->getCategories(
            $this->get('ongr_settings.settings_manager')->getCachedValue('content_disable_premium_categories'),
            $this->getUser()
        );

        return $this->render('default/category.html.twig', [
            'document' => $document,
            'categories' => $categories,
            'filters' => $this->get('ongr_filter_manager.article')->handleRequest($request),
        ]);
    }
}
