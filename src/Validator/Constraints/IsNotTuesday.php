<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/02/2018
 * Time: 09:12
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class IsNotTuesday
 * @package App\Validator\Constraints
 * @Annotation
 */
class IsNotTuesday extends Constraint
{
    public $message = 'The museum for this date "{{ date }}" is not open on Thuesdays. ';

}