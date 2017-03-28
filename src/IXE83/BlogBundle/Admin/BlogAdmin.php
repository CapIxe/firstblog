<?php
// src/IXE83/BlogBundle/Admin/BlogAdmin.php

namespace IXE83\BlogBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BlogAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        // ... configure $formMapper
		$formMapper
			->add('title', 'text')
			->add('author', 'text')
			->add('blog', 'textarea')
			->add('image', 'file')
			->add('tags', 'text')
			->add('created', 'date')
			->add('updated', 'date')
			->add('slug', 'text')
			->add('category', 'entity', array(
				'class'=>'IXE83\BlogBundle\Entity\Cateory',
				'choice_label'=>'name'))
				;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        // ... configure $listMapper
    }
}