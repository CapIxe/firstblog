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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		 $permissions = array(
             'Author'        => 'ROLE_USER',
              'Admin'		=>'ROLE_ADMIN',
             );
        $builder
				->add('email', EmailType::class)
				/*->add('plainPassword', RepeatedType::class, array(
					'type' => PasswordType::class,
					'first_options' => array('label' => 'Password'),
					'second_options' => array('label' => 'Repeat password'),
					'invalid_message' => 'Passwords does not match. Try again,please'
					))*/
				->add('roles', ChoiceType::class, array(
								'label' => 'Roles',
								'choices'=> $permissions,
								'multiple' => true,
								'expanded' => true
								/*array('Admin','User'),
								'choices_as_values'=>array('ROLE_ADMIN','ROLE_USER'),*/
								));
    }
    
	public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
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
