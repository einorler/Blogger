<?php

namespace AppBundle\Service;

use AppBundle\Document\Category;
use AppBundle\Entity\User;
use ONGR\ElasticsearchBundle\Result\DocumentIterator;
use ONGR\ElasticsearchBundle\Service\Repository;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use Symfony\Component\HttpFoundation\Request;

class CategoryHandler
{
    /**
     * @var Repository
     */
    private $repo;

    /**
     * ArticleHandler constructor.
     * @param Repository $repo
     */
    public function __construct(Repository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return array
     */
    public function getNameArray()
    {
        $names = [];

        /**
         * @var Category $category
         */
        foreach ($this->getCategories() as $category) {
            $names[$category->getId()] = $category->getName();
        }

        return $names;
    }



    /**
     * @param bool $disablePremium
     * @param User $user
     * @return DocumentIterator
     */
    public function getCategories($disablePremium = false, $user = null)
    {
        $search = new Search();

        if ($disablePremium && !$user) {
            $search->addQuery(new TermQuery('premium', false));
        } else {
            $search->addQuery(new MatchAllQuery());
        }
        return $this->repo->findDocuments($search);
    }
}
