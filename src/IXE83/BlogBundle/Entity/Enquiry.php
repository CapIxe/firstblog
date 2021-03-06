<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IXE83\BlogBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;


class Enquiry
{
    protected $name;
    
    protected $email;
    
    protected $subject;
    
    protected $body;
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank());
        $metadata->addPropertyConstraint('email', new Email());
        $metadata->addPropertyConstraint('subject', new Length(array(
            'max' => 50
        )));
        $metadata->addPropertyConstraint('body', new Length(array(
            'min' => 50    
        )));
    }
    
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
        
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        return $this->name = $name;
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        return $this->email = $email;
    }
    
    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        return $this->subject = $subject;
    }
    
    /**
    * @return mixed
    */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
    * @param mixed $body
    */
    public function setBody($body)
    {
        return $this->body = $body;
    }
}