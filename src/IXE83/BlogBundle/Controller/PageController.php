<?php
// src/IXE83/BlogBundle/Controller/PageController.php

namespace IXE83\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use IXE83\BlogBundle\Entity\Enquiry;
use IXE83\BlogBundle\Form\EnquiryType;
use Doctrine\ORM\Tools\Pagination\Paginator;


class PageController extends Controller
{
	
    public function indexAction($page)
    {
		$em = $this->getDoctrine()->getManager();
		
		$blogs = $em->getRepository('IXE83BlogBundle:Blog')
					->getLatestBlogs();
		
		/*$dql = "SELECT p, c FROM BlogPost p JOIN p.comments c";
		$query = $entityManager->createQuery($dql)
							   ->setFirstResult(0)
							   ->setMaxResults(100);

		$paginator = new Paginator($query, $fetchJoinCollection = true);

		$c = count($paginator);
		foreach ($paginator as $post) {
			echo $post->getHeadline() . "\n";*/
		
        return $this->render('IXE83BlogBundle:Page:index.html.twig', array(
			'blogs' => $blogs
		));
    }
	
	public function aboutAction()
	{
		return $this->render('IXE83BlogBundle:Page:about.html.twig');
	}
	public function contactAction(Request $request)
	{
		$enquiry = new Enquiry();
		
		$form = $this->createForm(EnquiryType::class, $enquiry);
		
		if ($request->isMethod($request::METHOD_POST)){
			$form->handleRequest($request);
			
			if($form->isValid()){
				$message = \Swift_Message::newInstance()
					->setSubject('Contact enquiry from symblog')
					->setFrom('enquiries@symblog.co.uk')
					->setTo($this->container->getParameter('ixe83_blog.emails.contact_email'))
					->setBody($this->renderView('IXE83BlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
				
				$this->get('mailer')->send($message);
			
				$this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was succesfully sent.Thank you!');
				
				// Redirect - This is important to prevent users re-posting
				// the form if they refresh the page
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
		
		$tags = $em->getRepository('IXE83BlogBundle:Blog')->getTags();
		
		$tagWeights = $em->getRepository('IXE83BlogBundle:Blog')->getTagWeights($tags);
		
		return $this->render('IXE83BlogBundle:Page:sidebar.html.twig', array(
			'tags' => $tagWeights
		));
	}
}
