<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 14:30
 */

namespace App\Validator;


use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsDayTicketsPossibleValidator extends ConstraintValidator
{
    CONST LIMIT_TIME = 14;
    CONST TIMEZONE = 'Europe/Paris';
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$this->isDayTicketsPossible()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

    public function getSelectedDate():\DateTime
    {
        $order = $this->session->get('order');
        return $order->getDate();
//        dump($order);die();
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
        return true;
    }
}