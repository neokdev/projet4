<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 14:30
 */
namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsNotSundayValidator
 */
class IsNotSundayValidator extends ConstraintValidator
{
    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (date_format($value, "D") === "Sun") {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
