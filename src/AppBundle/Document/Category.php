<?php

namespace AppBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\RouterBundle\Document\SeoAwareInterface;
use ONGR\RouterBundle\Document\SeoAwareTrait;

/**
 * Class Article
 * @package AppBundle\Document
 * @ES\Document(type="category")
 */
class Category implements SeoAwareInterface
{
    use SeoAwareTrait;

    /**
     * @var string
     *
     * @ES\Id()
     */
    private $id;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    private $name;

    /**
     * @var bool
     * @ES\Property(type="boolean")
     */
    private $premium;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return boolean
     */
    public function getPremium()
    {
        return $this->premium;
    }

    /**
     * @param boolean $premium
     */
    public function setPremium($premium)
    {
        $this->premium = $premium;
    }
}
