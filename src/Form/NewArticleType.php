<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 16/05/19
 * Time: 15:50
 */

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Brands;
use App\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\ImageType;


class NewArticleType extends AbstractType
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
            ->add('name', null, [
                'attr' => ['autofocus' => true, 'class'=>'form-control'],
                'label' => 'Name',
            ])
            ->add('description', null, [
                'attr' => ['rows' => 20, 'class'=>'form-control'],
                'label' => 'Description'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name'])
            ->add('brand', EntityType::class, [
                'class' => Brands::class,
                'choice_label' => 'name'])
            ->add('retailDate', DateType::class,[
                'label' => 'Retail date',
                'required' => false
            ])
            ->add('image',ImageType::class)
        ;

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }

}