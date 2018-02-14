<?php

namespace App\Form;

use App\Entity\Products;
use App\Validator\Constraints\IsNotTuesday;
use App\Validator\Constraints\IsOpenDays;
use App\Validator\Constraints\IsTicketsAvalaible;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, array(
                'label' => 'order.event_date',
                'widget' => 'single_text',
                'constraints' => array(
                    //new IsNotTuesday(),
                    new IsOpenDays(),
                    new IsTicketsAvalaible())
                //'attr' => ['class' => 'js-datepicker'],
                //'html5' =>  false
            ))
            ->add('order.next_step', SubmitType::class, array(
                'label' => 'order.next_step',
            ))
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
