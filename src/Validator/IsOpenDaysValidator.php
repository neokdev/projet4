<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/02/2018
 * Time: 13:58
 */

namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsOpenDaysValidator extends ConstraintValidator
{
    /**
     * Closed dates list
     */
    CONST CLOSED_DATES = ["01-05", "01-11", "25-12"];

    /**
     * @param mixed $date
     * @param Constraint $constraint
     */
    public function validate($date, Constraint $constraint)
    {
        foreach(IsOpenDaysValidator::CLOSED_DATES as $closeddate) {
            if ($closeddate === date_format($date, "d-m")) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}