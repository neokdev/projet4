<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsValidNameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (1 !== preg_match('/([A-Z][a-zA-Z]*)/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

        
    }
}
