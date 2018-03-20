<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 09:19
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsNotTuesdayValidator
 */
class IsNotTuesdayValidator extends ConstraintValidator
{
    /**
     * @param mixed      $date
     * @param Constraint $constraint
     */
    public function validate($date, Constraint $constraint)
    {
        if (date_format($date, "D") === "Tue") {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
