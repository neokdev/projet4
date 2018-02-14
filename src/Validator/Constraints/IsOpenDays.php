<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/02/2018
 * Time: 14:00
 */

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class IsOpenDays extends Constraint
{
    /**
     * @var string
     */
    public $message = 'closedthisday';

    /**
     * @return mixed|string
     */
    public function validatedBy()
    {
        return str_replace('\Constraints', '', get_class($this).'Validator');
    }
}