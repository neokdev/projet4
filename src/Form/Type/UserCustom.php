<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 05/02/2018
 * Time: 09:45
 */

namespace App\Form\Type;

use App\Service\Wizard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserCustom extends AbstractType
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
        return BaseType::class;
    }
}