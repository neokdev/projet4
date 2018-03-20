<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 29/01/2018
 * Time: 21:00
 */

namespace App\Controller;

use App\Services\Order\Charge;
use App\Services\Order\Checkout;
use App\Services\Order\Pages;
use App\Services\Order\Previous;
use App\Services\Order\Success;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrderController
 */
class OrderController extends AbstractController
{
    /**
     * @Route(
     *     "/order",
     *     name="app_order",
     *     )
     * @param Request $request
     * @param Pages   $pages
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response
     */
    public function order(Request $request, Pages $pages)
    {
        return new Response($pages->step($request));
    }

    /**
     * @Route(
     *     "/previous",
     *     name="app_previous",
     *     methods={"GET"}
     *     )
     * @param Previous $previous
     *
     * @return Response
     */
    public function previous(Previous $previous)
    {
        return new Response($previous->previous());
    }

    /**
     * @Route(
     *     "/checkout",
     *     name="app_checkout",
     *     methods={"GET"}
     *     )
     * @param Request  $request
     * @param Checkout $checkout
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response
     */
    public function checkout(Request $request, Checkout $checkout)
    {
        return new Response($checkout->checkout($request));
    }

    /**
     * @Route(
     *     "/charge",
     *     name="app_charge",
     *     methods={"POST"}
     * )
     * @param Request $request
     * @param Charge  $charge
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response
     */
    public function charge(Request $request, Charge $charge)
    {
        return new Response($charge->charge($request));
    }

    /**
     * @Route(
     *     "/success",
     *     name="app_success",
     *     methods={"GET"}
     *     )
     * @param Success $success
     *

     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return Response
     */
    public function success(Success $success)
    {
        return new Response($success->success());
    }
}
