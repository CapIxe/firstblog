<?php
//src/IXE83/BlogBundle/Controller/BlogController.php

namespace IXE83\BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use IXE83\BlogBundle\Entity\Blog;
use IXE83\BlogBundle\Entity\Category;
use IXE83\BlogBundle\Form\BlogType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
* Blog controller
*/
class BlogController extends Controller
{
	/**
	* Show a blog entry
	*/
	public function showAction($id, $slug)
	{
		$em = $this->getDoctrine()->getManager();
		
		$blog = $em->getRepository('IXE83BlogBundle:Blog')->find($id);
		
		if (!$blog)
		{
			throw $this->createNotFoundException('Unable to find Blog post.');
		}
		
		$comments = $em->getRepository('IXE83BlogBundle:Comment')
						->getCommentsForBlog($blog->getId());
		
		return $this->render('IXE83BlogBundle:Blog:show.html.twig', array(
			'blog' =>$blog,
			'comments' =>$comments
		));
	}
	
	/**
	* @Security("has_role('ROLE_USER')")
	*/
	public function newAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		//$categories = $em->getRepository('IXE83BlogBundle:Category')->getCategory();
		//foreach ($categories as $category)
		//{
		//	$name = $category('name');
		//}
		//$query = $em->createQuery('SELECT c.name FROM IXE83BlogBundle:Category c');
		//$name = $query->getResult();
		//var_dump($name);
		
		$blog = new Blog;
		$blog->setAuthor('Alex');
		$blog->setCreated(new \DateTime('now'));
		$newForm = $this->createFormBuilder($blog)
						->add('title', TextType::class)
						->add('blog', TextareaType::class)
						->add('image', FileType::class)
						->add('tags', TextType::class)
						->add('category', EntityType::class, array(
										'class'=>'IXE83BlogBundle:Category' ,
										'choice_label'=> 'name',))
						->add('status', ChoiceType::class, array('choices'=>array('publish'=> true, 'draft'=>false,)))
						->add('save', SubmitType::class, array('label'=>'Add post'))
						->getForm();
		$blog->setSlug($blog->getTitle());
						
		$newForm->handleRequest($request);
		
		if ($newForm->isSubmitted() && $newForm->isValid()){
			$em =$this->getDoctrine()->getManager();
			$file = $blog->getImage();
			$fileName = md5(uniqid()).'.'.$file->guessExtension();
			$file->move($this->getParameter('images_directory'), $fileName);
			$blog->setImage($fileName);
			$em->persist($blog);
			$em->flush($blog);
			
			return $this->redirect($this->generateUrl('IXE83BlogBundle_homepage'));
		}
		
		return $this->render('IXE83BlogBundle:Blog:new.html.twig', array(
			'blog'=>$blog,
			'form'=>$newForm->createView(),
		));
	}
	
	/**
	* @Security("has_role('ROLE_USER')")
	*/
	public function deleteAction(Request $request, Blog $blog)
	{
		$form = $this->createDeleteForm($blog);
		$form->handleRequest($request);
		
		if($form->isSubmitted() && $form->isValid()){
			$em = $this->getDoctrine()->getManager();
			$em->remove($blog);
			$em->flush($blog);
		}
		return $this->redirectToRoute('IXE83BlogBundle_homepage');
	}
	
	/**
	* @Security("has_role('ROLE_USER')")
	*/
	public function editAction(Request $request, Blog $blog)
	{
		$deleteForm = $this->createDeleteForm($blog);
		$blog->setUpdated(new \DateTime('now'));
		$editForm = $this->createFormBuilder($blog)
						->add('title', TextType::class)
						->add('blog', TextareaType::class)
						->add('tags', TextType::class)
						->add('category', EntityType::class, array(
										'class'=>'IXE83BlogBundle:Category' ,
										'choice_label'=> 'name',))
						->add('status', ChoiceType::class, array('choices'=>array('publish'=> true, 'draft'=>false,)))
						->add('save', SubmitType::class, array('label'=>'Save changes'))
						->getForm();
		$editForm->handleRequest($request);
		
		if ($editForm->isSubmitted() && $editForm->isValid()){
			$this->getDoctrine()->getManager()->flush();
			
			return $this->redirectToRoute('IXE83BlogBundle_blog_show', array(
			'id' => $blog->getId(),
			'slug'=> $blog->getSlug()
			));
		}
		
		return $this->render('IXE83BlogBundle:Blog:edit.html.twig', array(
				'blog'=>$blog,
				'editForm'=>$editForm->createView(),
				'deleteForm'=>$deleteForm->createView(),
		
		));
	}
	
	public function createDeleteForm(Blog $blog)
	{
		return $this->createFormBuilder()
					->setAction($this->generateUrl('IXE83BlogBundle_blog_delete', array('id'=>$blog->getId())))
					->setMethod('DELETE')
					->getForm();
	}
	
}