<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 08/03/2018
 * Time: 09:49
 */

namespace App\Service;


class IdHelper
{
    public function createId():string
    {
        return md5(uniqid());
    }
}