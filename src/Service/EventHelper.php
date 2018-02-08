<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 05/02/2018
 * Time: 16:43
 */

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class EventHelper
{
    private $emi;
    public function __construct(EntityManagerInterface $emi)
    {
        $this->emi = $emi;
    }
    public function getDate($repo, $id)
    {
        $this->emi->getRepository($repo)->find($id);
    }
}