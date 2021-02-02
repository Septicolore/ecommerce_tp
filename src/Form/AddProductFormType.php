<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('createdate')
            ->add('img', FileType::class, [
                'mapped' =>false,
            ])
            ->add('favori')
            ->add('slug')
            ->add('Pcstuff', null, [
                'choice_label' => 'name'
    ])
            ->add('color')
            ->add('promotion', ChoiceType::class,  [
                'choices' => [
                    'Pas en promotion' => 0,
                    '10%' => 10,
                    '20%' => 20,
                    '30%' => 30,
                    '40%' => 40,
                    '50%' => 50,
                    '60%' => 60,
                    '70%' => 70,
                    '80%' => 80,
                    '90%' => 90,
                    '100%' => 100,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
