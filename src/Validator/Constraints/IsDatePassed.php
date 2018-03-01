<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsDatePassed extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'datePassed';

    public function validatedBy()
    {
        return str_replace('\Constraints', '', get_class($this).'Validator');
    }
}