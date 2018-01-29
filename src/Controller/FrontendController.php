<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 29/01/2018
 * Time: 21:00
 */

namespace App\Controller;

use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class FrontendController extends AbstractController
{
    private $twig;
    private $doctrine;

    public function __construct(Environment $twig, ManagerRegistry $doctrine)
    {
        $this->twig = $twig;
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('homepage.html.twig');
    }
}