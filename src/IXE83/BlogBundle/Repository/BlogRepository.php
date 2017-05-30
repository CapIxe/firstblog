<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IXE83\BlogBundle\Repository;

/**
 * BlogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlogRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLatestBlogs($limit = null)
    {
        $qb = $this->createQueryBuilder('b')
            ->select('b, c, t')
            ->where('b.status = true')
            ->leftJoin('b.comments', 'c')
            ->leftJoin('b.tags', 't')
            ->orderBy('b.created', 'DESC');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
    
    public function getCategoryBlogs($id, $limit = null)
    {
        $qb = $this->createQueryBuilder('b')
            ->select('b')
            ->where('b.status = true', 'b.category = :category_id')
            ->orderBy('b.created', 'DESC')
            ->setParameter('category_id', $id);

        return $qb->getQuery()->getResult();
    }
       
    public function getTags()
    {
        $blogTags = $this->createQueryBuilder('b')
                    ->select('b, t')
                    ->leftJoin('b.tags','t')
                    ->getQuery()
                    ->getResult();
        
        $tags = [];
        
        foreach ($blogTags as $blogTag)
        {
            $tags = array_merge ($blogTag['tags'], $tags);
        }
        
        foreach ($tags as &$tag)
        {
            $tag = trim($tag);
        }
        
        return $tags;
    }

    public function getTagWeights($tags)
    {
        $tagWeights = array ();
        if (empty($tags))
            return $tagWeights;
        
        foreach ($tags as $tag) {
            $tagWeights[$tag] = (isset($tagWeights[$tag])) ? $tagWeights[$tag]+1 : 1;
        }
        //Shuffle the tags
        uksort($tagWeights, function() {
            return rand()>rand();
        });
        
        $max = max($tagWeights);
        
        //Max of 5 weights
        $multiplier = ($max > 5) ? 5 / $max : 1;
        
        foreach ($tagWeights as &$tag) {
            $tag = ceil($tag * $multiplier);
        }
        
        return $tagWeights;
    }
}