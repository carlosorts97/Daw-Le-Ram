<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 24/05/19
 * Time: 13:36
 */

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Brands;


class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $category=$this->em->getRepository(Brands::class)->findAll();

        // For the full reference of options defined by each form field type
        // see https://symfony.com/doc/current/reference/forms/types.html
        // By default, form fields include the 'required' attribute, which enables
        // the client-side form validation. This means that you can't test the
        // server-side validation errors from the browser. To temporarily disable
        // this validation, set the 'required' attribute to 'false':
        // $builder->add('title', null, ['required' => false, ...]);

        $builder
            ->add(

                'name', ChoiceType::class,  array(
                'label'=>'Brand Name',
                'choices'=>array($category),
                'choice_label' => function($category, $key, $index) {
                    return strtoupper($category->getName());
                },
            ))
        ;
    }

}