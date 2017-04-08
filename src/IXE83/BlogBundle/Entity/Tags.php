<?php

namespace IXE83\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="IXE83\BlogBundle\Repository\TagsRepository")
 */
class Tags
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
     * @var string
     *
     * @ORM\Column(name="tagname", type="string", length=255, unique=true)
     */
    private $tagname;


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
     * Set tagname
     *
     * @param string $tagname
     *
     * @return Tags
     */
    public function setTagname($tagname)
    {
        $this->tagname = $tagname;

        return $this;
    }

    /**
     * Get tagname
     *
     * @return string
     */
    public function getTagname()
    {
        return $this->tagname;
    }
}

