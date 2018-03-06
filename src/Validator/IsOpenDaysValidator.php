<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 13:58
 */

namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Service\Holidays;

class IsOpenDaysValidator extends ConstraintValidator
{
    /**
     * @var Holidays
     */
    private $holidays;

    public function __construct(Holidays $holidays)
    {
        $this->holidays = $holidays;
    }

    /**
     * @param mixed $date
     * @param Constraint $constraint
     */
    public function validate($date, Constraint $constraint)
    {
        $year = date('Y', date_timestamp_get($date));
        foreach($this->retrieveHolidayDates($year) as $closeddate) {
            if ($closeddate === date_format($date, "Y-m-d")) {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }

    public function retrieveHolidayDates($year):array
    {
        foreach ($this->holidays->getHolidays($year) as $days) {
            $array[] = date('Y-m-d', $days);
        }
        return $array;
    }
}