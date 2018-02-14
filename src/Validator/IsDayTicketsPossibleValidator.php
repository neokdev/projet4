<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/02/2018
 * Time: 14:30
 */

namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsDayTicketsPossibleValidator extends ConstraintValidator
{
    CONST LIMIT_TIME = 14;
    CONST TIMEZONE = 'Europe/Paris';

    public function validate($value, Constraint $constraint)
    {
        if (IsDayTicketsPossibleValidator::LIMIT_TIME < $value) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}