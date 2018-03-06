<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 14:30
 */

namespace App\Validator;


use App\Service\DateHelper;
use App\Service\TimeHelper;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsDayTicketsPossibleValidator extends ConstraintValidator
{
    CONST LIMIT_TIME = "14:00";
    CONST TIMEZONE = 'Europe/Paris';
    /**
     * @var DateHelper
     */
    private $dateHelper;
    /**
     * @var TimeHelper
     */
    private $timeHelper;

    public function __construct(DateHelper $dateHelper, TimeHelper $timeHelper)
    {
        $this->dateHelper = $dateHelper;
        $this->timeHelper = $timeHelper;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$this->isDayTicketsPossible() && $value) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function isDateToday():bool
    {
        date_default_timezone_set(IsDayTicketsPossibleValidator::TIMEZONE);
        return ((date_format($this->dateHelper->getSelectedDate(), "Y-m-d")) == (date_format($this->dateHelper->getActualDatetime(), "Y-m-d")));
    }

    public function isDayTicketsPossible():bool
    {
        if (!$this->isDateToday()) {
            return true;
        } elseif ($this->isDateToday() && $this->timeHelper->isTimeExceed(IsDayTicketsPossibleValidator::LIMIT_TIME)) {
            return false;
        }
        return true;
    }
}