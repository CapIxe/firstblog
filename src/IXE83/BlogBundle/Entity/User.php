<?php
//src/IXE83/BlogBundle/Entity/User.php

namespace IXE83\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	
	
	public function __construct()
	{
		parent::__construct();
		//add logic!
	}

}
