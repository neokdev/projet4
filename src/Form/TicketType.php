<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 05/02/2018
 * Time: 09:45
 */

namespace App\Form;

use App\Entity\Ticket;
use App\Validator\Constraints\IsBorn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Validator\Constraints\IsValidName;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Class TicketType
 */
class TicketType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/[a-zA-Z]\S+/',
                        'message' => 'nameNotValid',
                    ]),
                ],
                'label'       => 'user.name',
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/[a-zA-Z]\S+/',
                        'message' => 'nameNotValid',
                    ]),
                ],
                'label'       => 'user.firstname',
            ])
            ->add('country', CountryType::class, [
                'label'       => 'user.country',
                'placeholder' => 'selectCountry',
            ])
            ->add('birthdate', DateType::class, [
                'constraints' => [
                    new IsBorn(),
                ],
                'widget'      => 'single_text',
                'label'       => 'user.birthday',
            ])
            ->add('reducedPrice', CheckboxType::class, [
                'label'    => 'reducedPrice',
                'required' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
