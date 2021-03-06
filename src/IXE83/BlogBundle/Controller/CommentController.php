<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IXE83\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IXE83\BlogBundle\Entity\Comment;
use IXE83\BlogBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
* @Security("is_granted('IS_AUTHENTICATED_FULLY')")
*/
class CommentController extends Controller
{
    
    public function newAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);
        
        $comment = new Comment();
        
        $comment->setBlog($blog);
        
        $form = $this->createForm(CommentType::class, $comment);
        
        return $this->render('IXE83BlogBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView()
        ));
    }

    public function createAction (Request $request, $blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $comment = new Comment();
        
        $comment->setBlog($blog);
        
        $comment->setUser($user);
        
        $form = $this->createForm(CommentType::class, $comment);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($comment);
            
            $em->flush();
            
            return $this->redirect($this->generateUrl('IXE83BlogBundle_blog_show', array(
                'id'=>$comment->getBlog()->getId(),
                'slug'=>$comment->getBlog()->getSlug())) .
                '#comment-' . $comment->getId()
            );
        }
        
        return $this->render('IXE83BlogBundle:Comment:create.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView()
        ));
    }
    
    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()->getManager();
            
        $blog = $em->getRepository('IXE83BlogBundle:Blog')->find($blog_id);
        
        if(!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }
        
        return $blog;
    }
}