<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */
namespace App\Form;

use App\Entity\TicketOrder;
use App\Validator\Constraints\IsDatePassed;
use App\Validator\Constraints\IsNotSunday;
use App\Validator\Constraints\IsNotTuesday;
use App\Validator\Constraints\IsOpenDays;
use App\Validator\Constraints\IsTicketsAvalaible;
use App\Validator\Constraints\IsTooLateForToday;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TicketOrderDateType
 */
class TicketOrderDateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'label'       => 'order.eventDate',
                'widget'      => 'single_text',
                'constraints' => [
                    new IsNotTuesday(),
                    new IsNotSunday(),
                    new IsOpenDays(),
                    new IsTicketsAvalaible(),
                    new IsDatePassed(),
                    new IsTooLateForToday(),
                ],
            ])
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
