<?php

namespace IXE83\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;


/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="IXE83\BlogBundle\Entity\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Comment
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
     * @ORM\Column(name="user", type="string", length=100)
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    protected $comment;

    /**
     * @var bool
     *
     * @ORM\Column(name="approved", type="boolean")
     */
    protected $approved;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Blog", inversedBy="comments")
     * @ORM\JoinColumn(name="blog_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $blog;

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


    public static function loadValidatorMetadata(ClassMetadata $metadata)
	{
		$metadata->addPropertyConstraint('user', new NotBlank(array(
			'message' => 'You must enter your name'
		)));
		
		$metadata->addPropertyConstraint('comment', new NotBlank(array(
			'message' => 'You must enter a comment'
		)));
	}
	
	
    public function __construct()
    {
        $this->setCreated(new \DateTime());
		$this->setUpdated(new \DateTime());
		
		$this->setApproved(true);
    }
	
	/**
     * @ORM\preUpdate
     *
     */
    public function setUpdateValue()
    {
        $this->setUpdated(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Comment
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set approved
     *
     * @param boolean $approved
     *
     * @return Comment
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;

        return $this;
    }

    /**
     * Get approved
     *
     * @return boolean
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Comment
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
     * @return Comment
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

    /**
     * Set blog
     *
     * @param \IXE83\BlogBundle\Entity\Blog $blog
     *
     * @return Comment
     */
    public function setBlog(\IXE83\BlogBundle\Entity\Blog $blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return \IXE83\BlogBundle\Entity\Blog
     */
    public function getBlog()
    {
        return $this->blog;
    }
}
