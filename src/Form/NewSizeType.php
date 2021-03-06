<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 20/05/19
 * Time: 18:18
 */

namespace App\Form;


use App\Entity\Sizes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class NewSizeType extends AbstractType
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
            ->add('price', null, [
                'attr' => ['rows' => 20, 'class'=>'form-control mb-3'],
                'label' => 'Precio:'
            ])
            ->add('size', ChoiceType::class,[
                'attr' => ['class'=>'form-control'],
                'label' => 'Talla:',
                'choices' => [
                    'XL' => "XL",
                    'L' => "L",
                    'M' => "M",
                    'S' => "S"
                ],


            ])

        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sizes::class,
        ]);
    }
}