<?php

namespace IXE83\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="IXE83\BlogBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

	/**
    * @ORM\OneToMany(targetEntity="Blog", mappedBy="category")
	* 
    */
    private $blog;

    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
	 * 
     */
    private $name;
	
	/**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
	
	public function __construct()
    {
        $this->blog = new ArrayCollection();
    }

	
    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
	
	public function __toString()
	{
	  return $this->getName();
	}

    

    /**
     * Add blog
     *
     * @param \IXE83\BlogBundle\Entity\Blog $blog
     *
     * @return Category
     */
    public function addBlog(\IXE83\BlogBundle\Entity\Blog $blog)
    {
        $this->blog[] = $blog;

        return $this;
    }

    /**
     * Remove blog
     *
     * @param \IXE83\BlogBundle\Entity\Blog $blog
     */
    public function removeBlog(\IXE83\BlogBundle\Entity\Blog $blog)
    {
        $this->blog->removeElement($blog);
    }

    /**
     * Get blog
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlog()
    {
        return $this->blog;
    }
}
