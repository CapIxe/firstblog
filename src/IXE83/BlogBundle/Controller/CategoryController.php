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

use IXE83\BlogBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;

class CategoryController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('IXE83BlogBundle:Category')->findAll();
        
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        return $this->render('IXE83BlogBundle:Category:index.html.twig', array(
            'categories' => $categories,
            'username' => $user,
            ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        
        $form = $this->createForm('IXE83\BlogBundle\Form\CategoryType', $category);
        
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush($category);
            

            return $this->redirectToRoute('category_show', array('id' => $category->getId(),
                                                        'name' => $category->getName(),
                ));
        }

        return $this->render('IXE83BlogBundle:Category:new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $blogs = $em->getRepository('IXE83BlogBundle:Blog')->getCategoryBlogs($id);
        
        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $blogs,
            $request->query->getInt('page', 1), 5);
        
        
        return $this->render('IXE83BlogBundle:Page:index.html.twig', array(
            'blogs' => $pagination
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        
        $editForm = $this->createForm('IXE83\BlogBundle\Form\CategoryType', $category);\
        
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('IXE83BlogBundle_category_index');
        }

        return $this->render('IXE83BlogBundle:Category:edit.html.twig', array(
            'category' => $category,
            'name'=>'category',
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush($category);
        }

        return $this->redirectToRoute('IXE83BlogBundle_category_index');
    }

    /**
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
