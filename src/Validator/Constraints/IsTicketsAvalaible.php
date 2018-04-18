<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 13/02/2018
 * Time: 14:31
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class IsTicketsAvalaible
 */
class IsTicketsAvalaible extends Constraint
{
    /**
     * @var string
     */
    public $message = 'ticketsnotavalaible';

    /**
    * @return mixed|string
    */
    public function validatedBy()
    {
        return str_replace('\Constraints', '', get_class($this).'Validator');
    }
}
