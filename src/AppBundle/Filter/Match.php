<?php

namespace AppBundle\Filter;

use AppBundle\Entity\User;
use ONGR\ElasticsearchDSL\Query\BoolQuery;
use ONGR\ElasticsearchDSL\Query\MatchQuery;
use ONGR\ElasticsearchDSL\Query\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\FilterManagerBundle\Filter\FilterState;
use ONGR\FilterManagerBundle\Filter\Widget\Search\MatchSearch;
use ONGR\FilterManagerBundle\Search\SearchRequest;
use ONGR\SettingsBundle\Service\SettingsManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class Match extends MatchSearch
{
    /**
     * @var SettingsManager
     */
    private $settingsManager;

    /**
     * @var TokenStorage
     */
    private $user;

    /**
     * {@inheritdoc}
     */
    public function modifySearch(Search $search, FilterState $state = null, SearchRequest $request = null)
    {
        if ($state && $state->isActive()) {
            if (strpos($this->getField(), ',') !== false) {
                $subQuery = new BoolQuery();

                foreach (explode(',', $this->getField()) as $field) {
                    if (strpos($field, '^') === false) {
                        $subQuery->add(new MatchQuery($field, $state->getValue()), 'should');
                    } else {
                        list ($field, $boost) = explode('^', $field);

                        $subQuery->add(new MatchQuery($field, $state->getValue(), ['boost' => $boost, 'fuzziness' => 1]), 'should');
                    }
                }

                $search->addQuery($subQuery, 'must');
            } else {
                $search->addQuery(new MatchQuery($this->getField(), $state->getValue()), 'must');
            }

            $user = $this->user->getToken()->getUser();

            if (
                $this->settingsManager->getCachedValue('content_disable_premium_categories') &&
                !$user instanceof User
            ) {
                $search->addQuery(new TermQuery('premium', false));
            }
        }
    }

    /**
     * @param SettingsManager $settingsManager
     */
    public function setSettingsManager($settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    /**
     * @param TokenStorage $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}
