<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 05/02/2018
 * Time: 09:45
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceRange extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'placeholder' => 'Select a price',
            'choices' => array(
                'Day' => 'day',
                'Half-day' =>'halfday',
            ),
        ));
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}