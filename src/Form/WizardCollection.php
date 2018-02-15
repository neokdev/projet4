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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WizardCollection extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('order_number', CollectionType::class, array(
            'entry_type' => DateFormType::class,
            'entry_options' => array(
                'label'             => false,
                'allow_add'         => true,
                'prototype_data'    =>true),
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        ));
    }
}