<?php

namespace AppBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Collection\Collection;
use ONGR\RouterBundle\Document\SeoAwareInterface;
use ONGR\RouterBundle\Document\SeoAwareTrait;

/**
 * Class Article
 * @package AppBundle\Document
 * @ES\Document(type="article")
 */
class Article implements SeoAwareInterface
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
    private $title;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    private $author;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    private $image;

    /**
     * @var array
     * @ES\Property(type="string", options={"index"="not_analyzed"})
     */
    private $category;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    private $content;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    private $createdAt;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    private $updatedAt;

    /**
     * @var int
     * @ES\Property(type="integer")
     */
    private $hits;

    /**
     * @var int
     * @ES\Property(type="integer")
     */
    private $likes;

    /**
     * @var Comment[]
     * @ES\Embedded(class="AppBundle:Comment", multiple=true)
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new Collection();
    }

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Article
     */
    public function setCreatedAt($createdAt)
    {
        if ($createdAt instanceof \DateTime) {
            $this->createdAt = $createdAt;
        } else {
            $this->createdAt = new \DateTime($createdAt);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Article
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * @param int $hits
     * @return Article
     */
    public function setHits($hits)
    {
        $this->hits = $hits;

        return $this;
    }

    public function incrementHit()
    {
        $this->hits++;
    }

    /**
     * @return Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment[] $comments
     * @return Article
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @param Comment $comment
     * @return Article
     */
    public function addComment($comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    public function incrementLikes()
    {
        $this->likes++;
    }

    /**
     * @return array
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param array $category
     * @returns Article
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @returns Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @returns Article
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }
}
