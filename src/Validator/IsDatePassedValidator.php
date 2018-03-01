<?php

namespace App\Validator;

use App\Service\DateHelper;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsDatePassedValidator extends ConstraintValidator
{
    /**
     * @var DateHelper
     */
    private $helper;

    public function __construct(DateHelper $helper)
    {

        $this->helper = $helper;
    }
    public function validate($value, Constraint $constraint)
    {
        if ($this->isDatePassed($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

    }

    public function isDatePassed(\DateTime $dateTime)
    {
        return date_format($dateTime, "Y-m-d") < date_format($this->helper->getActualDatetime(), "Y-m-d");
    }
}
