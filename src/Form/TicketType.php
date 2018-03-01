<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 05/02/2018
 * Time: 09:45
 */

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'user.name',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'user.firstname',
            ])
            ->add('country', CountryType::class, [
                'label' => 'user.country',
                'placeholder' => 'selectcountry',
            ])
            ->add('birthdate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'user.birthday',
            ])
            ->add('reductedPrice', ChoiceType::class, [
                'label' => false,
                'expanded' => 'true',
                'multiple' => 'true',
                'choices' => [
                    'reducted_price' => true
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class
        ]);
    }
}

