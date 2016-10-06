<?php

namespace AppBundle\Filter;

use ONGR\ElasticsearchDSL\Query\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\FilterManagerBundle\Filter\FilterState;
use ONGR\FilterManagerBundle\Filter\Widget\Search\AbstractSingleValue;
use ONGR\FilterManagerBundle\Search\SearchRequest;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\Category as CategoryDocument;

class Category extends AbstractSingleValue
{
    /**
     * {@inheritdoc}
     */
    public function getState(Request $request)
    {
        $state = new FilterState();
        $document = $request->get('document');

        if (isset($document) && $document instanceof CategoryDocument) {
            $state->setActive(true);
            $state->setValue($document);
        }

        return $state;
    }

    /**
     * {@inheritdoc}
     */
    public function modifySearch(Search $search, FilterState $state = null, SearchRequest $request = null)
    {
        $search->addPostFilter(new TermQuery('category', $state->getValue()->getId()));
    }
}
