<?php

namespace IXE83\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="IXE83\BlogBundle\Repository\TagRepository")
 */
class Tag implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    protected $name;
	
	/**
     * @ORM\ManyToMany(targetEntity="Blog", mappedBy="tags")
     */
    protected $blogs;

	public function __construct()
	{
        $this->blogs = new ArrayCollection();
    }
	
	public function addBlog (Blog $blog)
	{
		$this->blogs[] = $blog;
	}
	
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tags
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get tagname
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
	/**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->name;
    }
	
	/**
     * @return string
     */
	public function __toString()
	{
    return $this->name;
	}

    /**
     * Remove blog
     *
     * @param \IXE83\BlogBundle\Entity\Blog $blog
     */
    public function removeBlog(\IXE83\BlogBundle\Entity\Blog $blog)
    {
        $this->blogs->removeElement($blog);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlogs()
    {
        return $this->blogs;
    }
}
