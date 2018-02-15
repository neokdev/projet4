<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 05/02/2018
 * Time: 09:45
 */

namespace App\Form\Type;

use App\Entity\Users;
use App\Service\Wizard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCustom extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'user.name',
            ))
            ->add('firstName', TextType::class, array(
                'label' => 'user.firstname',
            ))
            ->add('country', CountryType::class, array(
                'label' => 'user.country',
                'placeholder' => 'selectcountry',
            ))
            ->add('birthdate', DateType::class, array(
                'widget' => 'single_text',
                'label' => 'user.birthday',
            ));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class
        ]);
    }
}

