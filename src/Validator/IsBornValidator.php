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
 * Class IsBornValidator
 */
class IsBornValidator extends ConstraintValidator
{
    /**
     * @var DateHelper
     */
    private $helper;

    /**
     * IsBornValidator constructor.
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
        if (!$this->isBorn($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return bool
     */
    public function isBorn(\DateTime $dateTime):bool
    {
        return date_format($this->helper->getSelectedDate(), 'Y-m-d') >= date_format($dateTime, 'Y-m-d');
    }
}
