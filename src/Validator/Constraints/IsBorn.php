<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsBorn extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'isNotBorn';

    public function validatedBy()
    {
        return str_replace('\Constraints', '', get_class($this).'Validator');
    }
}
