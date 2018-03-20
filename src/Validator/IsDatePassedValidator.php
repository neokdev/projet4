<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 01/03/2018
 * Time: 11:15
 */
namespace App\Validator;

use App\Services\DateHelper;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsDatePassedValidator
 */
class IsDatePassedValidator extends ConstraintValidator
{
    /**
     * @var DateHelper
     */
    private $helper;

    /**
     * IsDatePassedValidator constructor.
     * @param DateHelper $helper
     */
    public function __construct(DateHelper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if ($this->isDatePassed($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    public function isDatePassed(\DateTime $dateTime)
    {
        return date_format($dateTime, "Y-m-d") < date_format($this->helper->getActualDatetime(), "Y-m-d");
    }
}
