<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 14/02/2018
 * Time: 17:21
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WizardCollection extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateForm', DateFormType::class, [
                'label' => false
        ])
            ->add('priceform', CollectionType::class, [
            'entry_type' => PriceFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype_name'=> '__children_name__',
                'by_reference'  => false,
                'attr' => [
                    'class' => 'child-collection',
                ],
        ])
        ->add('save', SubmitType::class, [
            'label' => 'submit',
            'attr' => ['class' => 'btn-secondary'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => false,
        ]);
    }
}