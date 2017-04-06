<?php
namespace IXE83\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
 
class SecurityController extends Controller
{
	/**
	* @Route("/login", name="login")
	*/
    public function loginAction(Request $request)
    {
	$authenticationUtils = $this->get('security.authentication_utils');

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('app/Resources/views/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
	}
    
}