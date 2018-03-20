<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 14:30
 */

namespace App\Validator;

use App\Repository\TicketOrderRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsTicketsAvalaibleValidator
 */
class IsTicketsAvalaibleValidator extends ConstraintValidator
{
    const DAY_BUY_LIMIT = 1000;
    /**
     * @var TicketOrderRepository
     */
    private $repository;

    /**
     * IsTicketsAvalaibleValidator constructor.
     * @param TicketOrderRepository $repository
     */
    public function __construct(TicketOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param mixed      $value
     * @param Constraint $constraint
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validate($value, Constraint $constraint)
    {
        $tickets = $this->repository->ticketsForThisDate($value);
        if (self::DAY_BUY_LIMIT <= $tickets) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
