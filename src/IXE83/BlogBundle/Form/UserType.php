<?php
// src/IXE83BlogBundle/Form/UserType.php
namespace IXE83\BlogBundle\Form;

use IXE83\BlogBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
				->add('email', EmailType::class)
				->add('plainPassword', RepeatedType::class, array(
					'type' => PasswordType::class,
					'first_options' => array('label' => 'Password'),
					'second_options' => array('label' => 'Repeat password'),
					'invalid_message' => 'Passwords does not match. Try again,please'
					))
				;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ixe83_blogbundle_user';
    }


}
