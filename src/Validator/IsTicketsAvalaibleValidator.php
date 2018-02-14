<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/02/2018
 * Time: 14:30
 */

namespace App\Validator;


use App\Repository\ProductsRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsTicketsAvalaibleValidator extends ConstraintValidator
{
    CONST DAY_BUY_LIMIT = 1000;
    /**
     * @var ProductsRepository
     */
    private $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {

        $this->productsRepository = $productsRepository;
    }
    public function validate($value, Constraint $constraint)
    {
        $tickets = $this->productsRepository->ticketsForThisDate($value);
        if (IsTicketsAvalaibleValidator::DAY_BUY_LIMIT <= $tickets) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}