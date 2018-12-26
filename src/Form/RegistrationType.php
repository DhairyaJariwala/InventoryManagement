<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('username', TextType::class,array(
                    'required' => true,
                    'label' => 'Username',
                    'attr' => [
                      'id' => 'uname',
                      'name' => 'username',
                      'placeholder' => "Enter Username",
                    ],
                ))
                ->add('email', EmailType::class,array(
                    'required' => true,
                    'label' => 'Email',
                    'attr' => [
                      'id' => 'email_id',
                      'name' => 'email',
                      'placeholder' => "Enter Email",
                    ],
                ))
                ->add('plainpassword', RepeatedType::class,[
                    'type' => PasswordType::class,
                    'invalid_message' => 'The Password fields must match.',
                    'required' => true,
                    'first_options' => ['label' => 'Password','attr' => ['placeholder' => 'Enter Password']],
                    'second_options' => ['label' => 'Repeat Password', 'attr' => ['placeholder' => 'Enter Confirm Password']],
                ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'attr' => array("novalidate"=>"novalidate")
        ));
    }
}
?>
