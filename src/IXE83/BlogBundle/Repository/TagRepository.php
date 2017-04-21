<?php

namespace IXE83\BlogBundle\Repository;

/**
 * TagsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TagRepository extends \Doctrine\ORM\EntityRepository
{
	public function getTags()
	{
		$blogTags = $this->createQueryBuilder('t')
					->select('t.name')
					->getQuery()
					->getResult();
					
		$tags = array_values($blogTags);
						
		return $tags;
	}
	
	public function getTagWeights($tags)
	{
		$tagWeights = array();
		if (empty($tags))
			return $tagWeights;
		
		foreach($tags as $tag)
		{
			$tagWeights[$tag] = (isset($tagWeights[$tag])) ? $tagWeights[$tag]+1 : 1;
		}
		//Shuffle the tags
		uksort($tagWeights, function(){
			return rand()>rand();
		});
		
		$max = max($tagWeights);
		
		//Max of 5 weights
		$multiplier = ($max > 5) ? 5 / $max : 1;
		foreach ($tagWeights as &$tag)
		{
			$tag = ceil($tag * $multiplier);
		}
		return $tagWeights;
	}
}
