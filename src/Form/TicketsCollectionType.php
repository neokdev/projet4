<?php

namespace App\Form;

use App\Entity\TicketOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketsCollectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
        )
        ->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                /** @var TicketOrder $data */
                $data = $event->getData();
                if ($data->getTicketCollection()->count() === 0) {
                    $form->addError(new FormError('noTicketAdded'));
                }
            }
        )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TicketOrder::class,
        ]);
    }
}
