<?php
/**
 * Created by PhpStorm.
 * User2: linux
 * Date: 05/02/19
 * Time: 17:23
 */

namespace App\Form;

use App\Entity\Cities;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                'required' => 'required',
                'label' => 'Username',
                'attr'=>[
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Username'
                ]
            ])
            ->add('name', TextType::class,[
                'required' => 'required',
                'label' => 'Nombre',
                'attr'=>[
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Name'
                ]
            ])
            ->add('surname', TextType::class,[
                'required' => 'required',
                'label' => 'Apellidos',
                'attr'=>[
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Surname'
                ]
            ])
            ->add('email', EmailType::class,[
                'required' =>'required',
                'label' => 'Email',
                'attr' =>[
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Email@email'
                ]
            ])
            ->add('telephone', TextType::class,[
                'required' => 'required',
                'label' => 'Teléfono',
                'attr'=>[
                    'class' => 'form-control mb-2',
                    'placeholder' => 'telephone'
                ]
            ])
            ->add('city', EntityType::class, [
                'class' => Cities::class,
                'label' => 'Ciudad',
                'choice_label' => 'name',
                    'attr'=>[
                        'class' => 'form-control mb-2',
                    ]]
            )

            ->add('address', TextType::class,[
                'required' => 'required',
                'label' => 'Dirección',
                'attr'=>[
                    'class' => 'form-control mb-2',
                    'placeholder' => 'address'
                ]
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha de cumpleaños',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'attr'=>[
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('plainpassword',RepeatedType::class,[
                'type' => PasswordType::class,
                'required' => 'required',
                'first_options' =>[
                    'label' => 'Contraseña',
                    'attr' =>[
                        'class' => 'form-control mb-2',
                        'placeholder' => 'Password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Repite contraseña',
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Repeat password'
                    ]
                ]
            ]);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=> 'App\Entity\User']);
    }
}