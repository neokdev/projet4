<?php

namespace App\Form\Type;

use App\Entity\TicketOrder;
use App\Validator\Constraints\IsNotTuesday;
use App\Validator\Constraints\IsOpenDays;
use App\Validator\Constraints\IsTicketsAvalaible;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketOrderDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'order.event_date',
                'widget' => 'single_text',
                'constraints' => [
                    new IsNotTuesday(),
                    new IsOpenDays(),
                    new IsTicketsAvalaible()
                ]
            ])
            ->add('duration', ChoiceType::class, [
                'label' => 'order.duration',
                'placeholder' => 'selectduration',
                'choices' => [
                    'day' => 'day',
                    'halfday' =>'halfday'
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TicketOrder::class,
        ]);
    }
}
