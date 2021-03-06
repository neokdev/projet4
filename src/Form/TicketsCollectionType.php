<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */
namespace App\Form;

use App\Entity\TicketOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;

/**
 * Class TicketsCollectionType
 */
class TicketsCollectionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'ticketCollection',
                CollectionType::class,
                [
                    'label'         => false,
                    'allow_add'     => true,
                    'allow_delete'  => true,
                    'entry_type'    => TicketType::class,
                    'constraints'   => [
                        new Count([
                            'min'        => 1,
                            'minMessage' => 'noTicketAdded',
                        ]),
                    ],
                    'entry_options' => [
                        'label' => false,
                    ],
                ]
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
