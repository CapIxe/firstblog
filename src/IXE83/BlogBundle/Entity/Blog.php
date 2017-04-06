<?php
//src/IXE83/BlogBundle/Entity/Blog.php

namespace IXE83\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Blog
 * @ORM\Entity()
 * @ORM\Table(name="blog")
 * @ORM\Entity(repositoryClass="IXE83\BlogBundle\Repository\BlogRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Blog
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=100)
     */
    protected $author;

    /**
     * @var string
     *
     * @ORM\Column(name="blog", type="text")
     */
    protected $blog;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=40)
     */
    protected $image;
	
	/**
     * @var string
     *
     * @ORM\Column(name="tags", type="text")
     */
    protected $tags;
    
	/**
	* @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
	*/
    protected $comments;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    protected $updated;

	/**
     * @ORM\Column(type="string")
     */
    protected $slug;
	
	/**
	* @ORM\ManyToOne(targetEntity="Category", inversedBy="name")
	* @JoinColumn(name="category_id", referencedColumnName="id")
	*/
	private $category;
	
	/**
	* @var bool
	*
	* @ORM\Column(name="status", type="boolean")
	*/
	public $status = false;
	
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
     * Set title
     *
     * @param string $title
     *
     * @return Blog
     */
    public function setTitle($title)
    {
        $this->title = $title;
		$this->setSlug($this->title);
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Blog
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set blog
     *
     * @param string $blog
     *
     * @return Blog
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return string
     */
    public function getBlog($length = null)
    {
		if (false === is_null($length) && $length>0)
			return substr($this->blog, 0, $length);
		else
			return $this->blog;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Blog
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
	
	/**
	* Set tags
	*
	* @param string $tags
	*
	* @return Tags
	*/
	public function setTags($tags)
	{
		$this->tags = $tags;
	}
	
	/**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }
	
	/**
	* Set status
	*
	* @param boolean $status
	*
	* return Status
	*/
	public function setStatus($status)
	{
		$this->status = $status;
	}
	
	/**
     * Get status
     *
     * @return boolean
     */
	 public function getStatus()
	 {
		 return $this->status;
	 }
	 
    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Blog
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Blog
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Blog
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
	
	public function __construct()
	{
		$this->comments = new ArrayCollection();
		
		$this->setCreated(new \DateTime());
		$this->setUpdated(new \DateTime());
	}
	
	/**
	* @ORM\PreUpdate
	*/
	public function setUpdatedValue()
	{
		$this->setUpdated(new \DateTime());
	}

    /**
     * Add comment
     *
     * @param \IXE83\BlogBundle\Entity\Comment $comment
     *
     * @return Blog
     */
    public function addComment(\IXE83\BlogBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \IXE83\BlogBundle\Entity\Comment $comment
     */
    public function removeComment(\IXE83\BlogBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }
	
	public function __toString()
	{
		return $this->getTitle();
	}

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Blog
     */
    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
	
	public function setCategory(Category $category)
	{
		$this->category = $category;
	}
	
	public function getCategory()
	{
		return $this->category;
	}
	
	public function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('#[^\\pL\d]+#u', '-', $text);
	
		//trim
		$text = trim($text, '-');
		
		//transliterate
		if(function_exists('iconv'))
		{
			$text = iconv('utf-8','us-ascii//TRANSLIT', $text);
		}
		
		// lowercase
		$text = strtolower($text);
		
		// remove unwanted characters
		$text = preg_replace('#[^-\w]+#', '', $text);
		
		if(empty($text))
		{
			return 'n-a';
		}
	return $text;
	}
}
