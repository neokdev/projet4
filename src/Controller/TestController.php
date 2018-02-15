<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 29/01/2018
 * Time: 21:00
 */

namespace App\Controller;

use App\Entity\Products;
use App\Entity\Task;
use App\Form\DateFormType;
use App\Form\PriceFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;


class TestController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     */
    public function index(Request $request)
    {
        $wizard = $this->createForm(CollectionType::class);

        $wizard->handleRequest($request);

        return $this->render('test.html.twig', [
            'form' => $wizard->createView(),
        ]);
    }
}