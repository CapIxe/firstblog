<?php

namespace IXE83\BlogBundle\Form;

use IXE83\BlogBundle\Entity\Blog;
use IXE83\BlogBundle\Form\Type\TagsInputType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class)
						->add('blog', TextareaType::class)
						->add('image', FileType::class)
						->add('tags', TagsInputType::class,array(
										'label'=>'Tags',
										'required'=>false,))
						->add('category', EntityType::class, array('class'=>'IXE83BlogBundle:Category',
										'choice_label'=> 'name',))
						->add('status', ChoiceType::class, array('choices'=>array('publish'=> true, 'draft'=>false,)));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IXE83\BlogBundle\Entity\Blog',
        ));
    }

    /**
     * {@inheritdoc}
     */
    /*public function getBlockPrefix()
    {
        return 'ixe83_blogbundle_blog';
    }*/


}
