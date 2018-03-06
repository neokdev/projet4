<?php

namespace App\Validator;

use App\Service\DateHelper;
use App\Service\TimeHelper;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsTooLateForTodayValidator extends ConstraintValidator
{
    CONST CLOSURE_HOUR = "17:00";
    /**
     * @var DateHelper
     */
    private $dateHelper;
    /**
     * @var TimeHelper
     */
    private $timeHelper;

    public function __construct(
        DateHelper $dateHelper,
        TimeHelper $timeHelper)
    {
        $this->dateHelper = $dateHelper;
        $this->timeHelper = $timeHelper;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($this->isSelectedToday($value) && $this->timeHelper->isTimeExceed(IsTooLateForTodayValidator::CLOSURE_HOUR)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function isSelectedToday(\DateTime $dateTime):bool
    {
        date_default_timezone_set(DateHelper::TIMEZONE);
        return ((date_format($dateTime, "Y-m-d")) == (date_format($this->dateHelper->getActualDatetime(), "Y-m-d")));
    }
}
