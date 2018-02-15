<?php

namespace App\Form;

use App\Entity\Products;
use App\Form\Type\UserCustom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', ChoiceType::class, array(
                'label' => 'order.price',
                'placeholder' => 'selectprice',
                'choices' => [
                    'day' => 'day',
                    'halfday' =>'halfday',
                ]
    ))
            ->add('usercustom', UserCustom::class, array(
                'label' => false
            ))
            ->add('order.adduser', ButtonType::class, array(
                'label' => '+',
            ))
            ->add('order.previous_step', SubmitType::class, array(
                'label' => 'order.previous_step',
                'validation_groups' => 'test',
        ))
            ->add('order.next_step', SubmitType::class, array(
                'label' => 'order.next_step',
                'validation_groups' => PriceFormType::class,
            ))
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class
        ]);
    }
}
