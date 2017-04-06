<?php>
namespace IXE83\BlogBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 
class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('IXE83BlogBundle:Admin:index.html.twig');
    }
}