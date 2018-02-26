<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 14:30
 */

namespace App\Validator;


use App\Entity\TicketOrder;
use App\Repository\TicketOrderRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsDayTicketsPossibleValidator extends ConstraintValidator
{
    /**
     * @var TicketOrder
     */
    private $order;

    public function __construct(TicketOrderRepository $order)
    {
        $this->order = $order;
    }

    CONST LIMIT_TIME = 14;
    CONST TIMEZONE = 'Europe/Paris';

    public function validate($value, Constraint $constraint)
    {
        if ($this->isDayTicketsPossible()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function getSelectedDate()
    {
        $this->order->getDate();
    }

    public function getActualDatetime()
    {
        return new \DateTime();
    }

    public function isToday():bool
    {
        return ((date_format($this->getSelectedDate(), "Y-m-d")) == (date_format($this->getActualDatetime(), "Y-m-d")));
    }

    public function isTimeExceed():bool
    {
        return ((date_format($this->getActualDatetime(), "H")) >= (IsDayTicketsPossibleValidator::LIMIT_TIME));
    }

    public function isDayTicketsPossible():bool
    {
        if (!$this->isToday()) {
            return true;
        } elseif ($this->isToday() && $this->isTimeExceed()) {
            return false;
        }
    }
}