<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsNotSundayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (date_format($value, "D") === "Sun")
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
