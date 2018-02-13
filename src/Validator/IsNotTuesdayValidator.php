<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/02/2018
 * Time: 09:19
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class IsNotTuesdayValidator extends ConstraintValidator
{
    public function validate($date, Constraint $constraint)
    {
        if (date_format($date, "D") === "Tue") {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ date }}', $date)
                ->addViolation();
        }
    }
}