<?php

namespace App\Form;

use App\Entity\TicketOrder;
use App\Form\Type\DurationType;
use App\Form\Type\TicketOrderDateType;
use App\Form\Type\TicketType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WizardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ticketCollection', CollectionType::class, [
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => TicketType::class,
                'entry_options' => [
                    'label' => false,
                ]
            ]
//            ->add('ticket', TicketType::class, [
//                'label' => false
//            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TicketOrder::class,
        ]);
    }
}
