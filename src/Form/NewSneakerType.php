<?php
/**
 * Created by PhpStorm.
 * User: linux
<<<<<<< HEAD
 * Date: 20/05/19
 * Time: 18:18
=======
 * Date: 01/06/19
 * Time: 13:31
>>>>>>> borja
 */

namespace App\Form;


use App\Entity\Sizes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class NewSneakerType extends AbstractType
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
                'attr' => ['rows' => 20, 'class'=>'form-control'],
                'label' => 'Precio'
            ])
            ->add('size', ChoiceType::class,[
                'choices' => [
                    '38' => "38",
                    '39' => "39",
                    '40' => "40",
                    '41' => "41",
                    '42' => "42",
                    '43' => "43",
                    '44' => "44",
                    '45' => "45"
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