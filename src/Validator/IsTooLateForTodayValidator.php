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
 * Class IsTooLateForTodayValidator
 */
class IsTooLateForTodayValidator extends ConstraintValidator
{
    const CLOSURE_HOUR = "17:00";
    /**
     * @var DateHelper
     */
    private $dateHelper;
    /**
     * @var TimeHelper
     */
    private $timeHelper;

    /**
     * IsTooLateForTodayValidator constructor.
     * @param DateHelper $dateHelper
     * @param TimeHelper $timeHelper
     */
    public function __construct(
        DateHelper $dateHelper,
        TimeHelper $timeHelper
    ) {
        $this->dateHelper = $dateHelper;
        $this->timeHelper = $timeHelper;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if ($this->isSelectedToday($value) && $this->timeHelper->isTimeExceed(self::CLOSURE_HOUR)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    public function isSelectedToday(\DateTime $dateTime):bool
    {
        date_default_timezone_set(DateHelper::TIMEZONE);

        return ((date_format($dateTime, "Y-m-d")) === (date_format($this->dateHelper->getActualDatetime(), "Y-m-d")));
    }
}
