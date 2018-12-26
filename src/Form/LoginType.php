<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder,array $options){
        $builder
                ->add('email', EmailType::class,array(
                    'required' => true,
                    'label' => 'Email',
                ))
                ->add('password', PasswordType::class,array(
                    'required' => true,
                    'label' => 'Password',
                ));
    } 
}
