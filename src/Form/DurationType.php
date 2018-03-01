<?php

namespace App\Form;

use App\Entity\TicketOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Validator\Constraints\IsDayTicketsPossible;


class DurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duration', ChoiceType::class, [
                'constraints' => [
                    new IsDayTicketsPossible()
                ],
                'label' => 'order.duration',
                'placeholder' => 'selectduration',
                'choices' => [
                    'day' => true,
                    'halfday' => false
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TicketOrder::class
        ]);
    }
}
