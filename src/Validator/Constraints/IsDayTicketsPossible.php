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
 * Class IsDayTicketsPossible
 */
class IsDayTicketsPossible extends Constraint
{
    public $message = 'dayTicketsNotAvalaible';

    /**
    * @return mixed|string
    */
    public function validatedBy()
    {
        return str_replace('\Constraints', '', get_class($this).'Validator');
    }
}
