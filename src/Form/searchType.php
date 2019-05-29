<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 28/05/19
 * Time: 17:54
 */

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Tests\Extension\Core\Type\SubmitTypeTest;
class searchType extends AbstractType
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
            ->add("query", TextType::class, [
                'attr' => [
                    'placeholder'   => 'Enter search query...'
                ]
            ])
            ->add("submit", SubmitTypeTest::class)
            ->getForm()
        ;
    }



}