<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 14:30
 */

namespace App\Validator;


use App\Service\DateHelper;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsDayTicketsPossibleValidator extends ConstraintValidator
{
    CONST LIMIT_TIME = 14;
    CONST TIMEZONE = 'Europe/Paris';

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
        if (!$this->isDayTicketsPossible() && $value) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function isToday():bool
    {
        date_default_timezone_set(IsDayTicketsPossibleValidator::TIMEZONE);
        return ((date_format($this->helper->getSelectedDate(), "Y-m-d")) == (date_format($this->helper->getActualDatetime(), "Y-m-d")));
    }

    public function isTimeExceed():bool
    {
        return ((date_format($this->helper->getActualDatetime(), "H")) >= (IsDayTicketsPossibleValidator::LIMIT_TIME));
    }

    public function isDayTicketsPossible():bool
    {
        if (!$this->isToday()) {
            return true;
        } elseif ($this->isToday() && $this->isTimeExceed()) {
            return false;
        }
        return true;
    }
}