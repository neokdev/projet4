<?php

namespace App\Validator;

use App\Service\DateHelper;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsBornValidator extends ConstraintValidator
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
        dump($this->isBorn($value));
        if (!$this->isBorn($value))
        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }

    public function isBorn(\DateTime $dateTime):bool
    {
        return date_format($this->helper->getSelectedDate(), 'Y-m-d') >= date_format($dateTime, 'Y-m-d');
    }
}
