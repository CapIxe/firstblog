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

use IXE83\BlogBundle\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_USER')")
 */
class TagController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tags = $em->getRepository('IXE83BlogBundle:Tag')->findAll();
                
        $paginator = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $tags,
            $request->query->getInt('page', 1), 10);
        
        return $this->render('IXE83BlogBundle:Tag:index.html.twig', array(
            'tags' => $pagination,
        ));
    }

    public function newAction(Request $request)
    {
        $tag = new Tag();
        
        $form = $this->createForm('IXE83\BlogBundle\Form\TagType', $tag);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($tag);
            
            $em->flush($tag);

            return $this->redirectToRoute('tag_show', array('id' => $tag->getId()));
        }

        return $this->render('IXE83BlogBundle:Tag:new.html.twig', array(
            'tag' => $tag,
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, Tag $tag)
    {
        $deleteForm = $this->createDeleteForm($tag);
        
        $editForm = $this->createForm('IXE83\BlogBundle\Form\TagType', $tag);
        
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tag_index');
        }

        return $this->render('IXE83BlogBundle:Tag:edit.html.twig', array(
            'tag' => $tag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    public function deleteAction(Request $request, Tag $tag)
    {
        $form = $this->createDeleteForm($tag);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $em->remove($tag);
            
            $em->flush($tag);
        }

        return $this->redirectToRoute('tag_index');
    }
    
    private function createDeleteForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_delete', array('id' => $tag->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
