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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;
  
 /**
 * @Security("has_role('ROLE_USER')")
 */
class AdminController extends Controller
{
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        } else {
            return $this->render('IXE83BlogBundle:Admin:index.html.twig');
        }
    }
    
    public function showpostsAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $author = $this->getUser()->getUsername();
        
        $blogs = $em->getRepository('IXE83BlogBundle:Blog')->findBy(['author'=>$author]);
        
        if (!$blogs) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        } else {                                 
            $paginator = $this->get('knp_paginator');
            
            $pagination = $paginator->paginate(
                $blogs,
                $request->query->getInt('page', 1), 5);
               
            return $this->render('IXE83BlogBundle:Page:index.html.twig', array(
                'blogs' => $pagination
            ));
        }    
    }
}