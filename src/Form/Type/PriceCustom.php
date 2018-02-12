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

class PriceCustom extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'placeholder' => 'selectprice',
            'choices' => array(
                'day' => 'day',
                'halfday' =>'halfday',
            ),
        ));
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}