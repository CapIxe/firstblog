<?php
// src/IXE83/BlogBundle/Controller/RegistrationController.php

namespace IXE83\BlogBundle\Controller;

use IXE83\BlogBundle\Form\UserType;
use IXE83\BlogBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
	/**
	* @Route("/register", name="user_registration")
	*/
	public function registerAction(Request $request)
	{
		// buil form
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		// handle the submit (will only happen on POST)
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid())
		{
			// Encode the password 
			$password = $this->get('security.password_encoder')
				->encodePassword($user, $user->getPlainPassword());
			$user->setPassword($password);
			
			//save the user
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			
			// ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
			
			return $this->redirectToRoute('IXE83BlogBundle_homepage');
		}
		return $this->render('IXE83BlogBundle:Registration:register.html.twig', array(
			'form' => $form->createView()));
	}
}