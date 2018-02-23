<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 22/02/2018
 * Time: 12:28
 */

namespace App\Service;


class Wizard
{
    private $step;

    public function __construct($step = 1)
    {
        $this->step = $step;
    }
    public function nextStep($step)
    {
        return $step+1;
    }

    public function previousStep($step)
    {
        return $step-1;
    }

    public function getStep()
    {
        return $this->step;
    }

    public function setStep($step)
    {
        $this->step = $step;
    }
}