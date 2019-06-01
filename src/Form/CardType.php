<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 01/06/19
 * Time: 10:43
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\CreditCard;

class CardType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // For the full reference of options defined by each form field type
        // see https://symfony.com/doc/current/reference/forms/types.html
        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        // $builder->add('title', null, ['required' => false, ...]);
        $builder
            ->add('owner', null, [
                'attr' => ['autofocus' => true, 'class'=>'form-control'],
                'label' => 'Titular',
            ])
            ->add('number', null, [
                'attr' => ['autofocus' => true, 'class'=>'form-control'],
                'label' => 'Numero',
            ])
            ->add('cvv', null, [
                'attr' => ['rows' => 20, 'class'=>'form-control'],
                'label' => 'CVV'
            ])
            ->add('endDate', null, [
                'attr' => ['rows' => 20, 'class'=>'form-control'],
                'label' => 'end date'
            ])

        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CreditCard::class,
        ]);
    }
}