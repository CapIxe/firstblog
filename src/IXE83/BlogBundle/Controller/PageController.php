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
use Symfony\Component\HttpFoundation\Request;
use IXE83\BlogBundle\Entity\Enquiry;
use IXE83\BlogBundle\Form\EnquiryType;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PageController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $blogs = $em->getRepository('IXE83BlogBundle:Blog')->getLatestBlogs();
                
        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $blogs,
            $request->query->getInt('page', 1), 5);
                
        return $this->render('IXE83BlogBundle:Page:index.html.twig', array(
            'blogs' => $pagination));
    }
        
    public function aboutAction()
    {
        return $this->render('IXE83BlogBundle:Page:about.html.twig');
    }
    
    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();
        
        $form = $this->createForm(EnquiryType::class, $enquiry);
        
        if ($request->isMethod($request::METHOD_POST)) {
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from symblog')
                    ->setFrom('enquiries@symblog.co.uk')
                    ->setTo($this->container->getParameter('ixe83_blog.emails.contact_email'))
                    ->setBody($this->renderView('IXE83BlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                
                $this->get('mailer')->send($message);
            
                $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was succesfully sent.Thank you!');
                
                return $this->redirect($this->generateUrl('IXE83BlogBundle_contact'));
            }
        }
        
        return $this->render('IXE83BlogBundle:Page:contact.html.twig', array(
            'form'=>$form->createView()
        ));
    }
    
    public function sidebarAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $tags = $em->getRepository('IXE83BlogBundle:Tag')->getTags();
       
        $query = $em->createQuery("SELECT c FROM IXE83BlogBundle:Category c JOIN c.blog b WHERE b.status = true GROUP BY b.category");
        
        $categories = $query->getResult();
           
        return $this->render('IXE83BlogBundle:Page:sidebar.html.twig', array(
            'tags' => $tags,
            'categories'=> $categories,
        ));
        
    }
}
