<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 14:30
 */

namespace App\Validator;

use App\Services\DateHelper;
use App\Services\TimeHelper;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsDayTicketsPossibleValidator
 */
class IsDayTicketsPossibleValidator extends ConstraintValidator
{
    const LIMIT_TIME = "14:00";
    /**
     * @var DateHelper
     */
    private $dateHelper;
    /**
     * @var TimeHelper
     */
    private $timeHelper;

    /**
     * IsDayTicketsPossibleValidator constructor.
     * @param DateHelper $dateHelper
     * @param TimeHelper $timeHelper
     */
    public function __construct(DateHelper $dateHelper, TimeHelper $timeHelper)
    {
        $this->dateHelper = $dateHelper;
        $this->timeHelper = $timeHelper;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$this->isDayTicketsPossible() && $value) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    /**
     * @return bool
     */
    public function isDateToday():bool
    {
        date_default_timezone_set(DateHelper::TIMEZONE);

        return ((date_format($this->dateHelper->getSelectedDate(), "Y-m-d")) === (date_format($this->dateHelper->getActualDatetime(), "Y-m-d")));
    }

    /**
     * @return bool
     */
    public function isDayTicketsPossible():bool
    {
        if (!$this->isDateToday()) {
            return true;
        }
        if ($this->isDateToday() && $this->timeHelper->isTimeExceed(self::LIMIT_TIME)) {
            return false;
        }

        return true;
    }
}
