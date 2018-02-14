<?php

namespace App\Form;

use App\Form\Type\PriceCustom;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderprice', PriceCustom::class, array(
                'label' => 'order.price',
    ))
            ->add('username', TextType::class, array(
                'label' => 'user.name',
            ))
            ->add('userfirstname', TextType::class, array(
                'label' => 'user.firstname',
            ))
            ->add('usercountry', CountryType::class, array(
                'label' => 'user.country',
            ))
            ->add('userbirthday', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'user.birthday',
            ))
            ->add('order.adduser', ButtonType::class, array(
                'label' => '+',
            ))
            ->add('order.previous_step', SubmitType::class, array(
                'label' => 'order.previous_step',
                'validation_groups' => true,
        ))
            ->add('order.next_step', SubmitType::class, array(
                'label' => 'order.next_step',
            ))
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            //'data_class' => PriceForm::class,
        ]);
    }
}
