<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */
namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactType
 */
class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'user.mail',
            ])
            ->add('messageType', ChoiceType::class, [
                'label' => 'messageType',
                'placeholder' => 'select',
                'choices' => [
                    'commandProblem' => 'commandProblem',
                    'noMailReceived' => 'noMailReceived',
                    'information' => 'information',
                    'other' => 'other',
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'subject',
                'attr' => [
                    'placeholder' => 'subjectPlaceholder',
                ],
            ])
            ->add('messageText', TextareaType::class, [
                'label' => 'messageText',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'label' => false,
        ]);
    }
}
