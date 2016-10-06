<?php

namespace AppBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * Class Article
 * @package AppBundle\Document
 * @ES\Nested
 */
class Comment
{
    /**
     * @var int
     * @ES\Property(type="integer")
     */
    private $number;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    private $commenter;

    /**
     * @var string
     * @ES\Property(type="string")
     */
    private $comment;

    /**
     * @var \DateTime
     * @ES\Property(type="date")
     */
    private $date;

    /**
     * @var int
     * @ES\Property(type="integer")
     */
    private $likes;

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     * @returns Comment
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommenter()
    {
        return $this->commenter;
    }

    /**
     * @param string $commenter
     * @returns Comment
     */
    public function setCommenter($commenter)
    {
        $this->commenter = $commenter;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @returns Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @returns Comment
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

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
     * @returns Comment
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    public function incrementLikes()
    {
        $this->likes++;
    }
}
