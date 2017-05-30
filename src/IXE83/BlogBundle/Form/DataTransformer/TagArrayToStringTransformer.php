<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace IXE83\BlogBundle\Form\DataTransformer;

use IXE83\BlogBundle\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;


class TagArrayToStringTransformer implements DataTransformerInterface
{
    private $manager;
    
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * {@inheritdoc}
     */
    public function transform($array)
    {
        return implode(',', $array);
    }
    
    /**
     * {@inheritdoc}
     */
    public function reverseTransform($string)
    {
        if ('' === $string || null === $string) {
            return [];
        }
        $names = array_filter(array_unique(array_map('trim', explode(',', $string))));
        
        $tags = $this->manager->getRepository(Tag::class)->findBy(['name' => $names, ]);
        
        $newNames = array_diff($names, $tags);
        
        foreach ($newNames as $name) {
            $tag = new Tag();
            
            $tag->setName($name);
            
            $tags[] = $tag; 
        }
        
        return $tags;
    }
}