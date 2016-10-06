<?php

namespace AppBundle\Service;

use AppBundle\Document\Article;
use AppBundle\Document\Comment;
use ONGR\ElasticsearchBundle\Service\Manager;
use ONGR\ElasticsearchBundle\Service\Repository;
use Symfony\Component\HttpFoundation\Request;

class ArticleHandler
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var string
     */
    private $kernelDir;

    /**
     * @param Repository $repository
     * @param string     $kernelDir
     */
    public function __construct(Repository $repository, $kernelDir)
    {
        $this->repository = $repository;
        $this->kernelDir = $kernelDir;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function addArticle(Request $request)
    {
        if (empty($title = $request->request->get('title'))) {
            return true;
        }

        if (empty($author = $request->request->get('author'))) {
            return true;
        }

        if (empty($category = $request->request->get('category'))) {
            return true;
        }

        if (empty($text = $request->request->get('text'))) {
            return true;
        }

        if (empty($image = $request->files->get('image'))) {
            return true;
        }

        $url = str_replace(' ', '_', strtolower($title));
        $url = preg_replace('/[^A-Za-z0-9\_]/', '', $url);
        $url = "/article/$url/";

        $filename = sprintf('%s.%s', sha1(uniqid(mt_rand(), true)), $image->guessExtension());
        $image->move($this->kernelDir . '/../web/images/', $filename);

        $article = (new Article())
            ->setTitle($title)
            ->setAuthor($author)
            ->setContent($text)
            ->setCategory($category)
            ->setCreatedAt(new \DateTime())
            ->setImage($filename);
        $article->setUrl($url);

        $this->repository->getManager()->persist($article);

        try {
            $this->repository->getManager()->commit();
        } catch (\Exception $e) {
            return true;
        }

        return false;
    }

    /**
     * @param Request $request
     * @param Article $article
     * @param string  $user
     *
     * @return bool
     */
    public function addComment(Request $request, Article $article, $user)
    {
        if (empty($comment = $request->request->get('comment'))) {
            return true;
        }

        if (empty($articleId = $request->request->get('article'))) {
            return true;
        }

        $count = count($article->getComments());
        $count = $count ? $count : 0;

        $comment = (new Comment())
            ->setDate(new \DateTime())
            ->setNumber($count)
            ->setLikes(0)
            ->setCommenter($user)
            ->setComment($comment);

        /** @var Article $article */
        $article->addComment($comment);

        $this->repository->getManager()->persist($article);
        $this->repository->getManager()->commit();


        try {
            $this->repository->getManager()->commit();
        } catch (\Exception $e) {
            return true;
        }

        return false;
    }

    /**
     * @var string $id
     *
     * @return Article
     */
    public function getArticle($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @var Article $article
     *
     * @return bool
     */
    public function saveArticle($article)
    {
        try {
            $this->repository->getManager()->persist($article);
            $this->repository->getManager()->commit();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
