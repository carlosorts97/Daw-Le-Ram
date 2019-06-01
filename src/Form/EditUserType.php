<?php
/**
 * Created by PhpStorm.
 * User2: linux
 * Date: 05/02/19
 * Time: 17:23
 */

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                'required' => 'required',
                'attr'=>[
                    'class' => 'form-username form-control',
                    'placeholder' => 'Username'
                ]
            ])
            ->add('name', TextType::class,[
                'required' => 'required',
                'attr'=>[
                    'class' => 'form-username form-control',
                    'placeholder' => 'Name'
                ]
            ])
            ->add('surname', TextType::class,[
                'required' => 'required',
                'attr'=>[
                    'class' => 'form-username form-control',
                    'placeholder' => 'Surname'
                ]
            ])
            ->add('email', EmailType::class,[
                'required' =>'required',
                'attr' =>[
                    'class' => 'form-email form-control',
                    'placeholder' => 'Email@email'
                ]
            ])
            ->add('plainpassword',PasswordType::class,[
                'required' => 'required',
                    'attr' =>[
                        'class' => 'form-password form-control',
                        'placeholder' => 'Password'
                    ]
            ])
            ->add('roles', ChoiceType::class,[
                'choices' => [
                    'ROLE_USER' => "ROLE_USER",
                    'ROLE_ADMIN' => "ROLE_ADMIN"
                ],
                'expanded'  => true,
                'multiple'  => true,
            ]);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=> 'App\Entity\User']);
    }
}