<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 01/03/2018
 * Time: 11:15
 */
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class IsNotSunday
 */
class IsNotSunday extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'closedonsundays';

    /**
     * @return mixed|string
     */
    public function validatedBy()
    {
        return str_replace('\Constraints', '', get_class($this).'Validator');
    }
}
