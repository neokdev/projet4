<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 29/01/2018
 * Time: 21:00
 */

namespace App\Controller;

use App\Manager\OrderManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="app_order")
     * @param Request $request
     * @param OrderManager $orderManager
     * @return Response
     */
    public function index(Request $request, OrderManager $orderManager)
    {
//        $ticket = new Ticket();
        $form = null;
        $template = null;
        switch ($this->get('session')->get('step')) {
            case 1:
                $form = $orderManager->stepOne($request);
                $template = 'order.html.twig';
                break;
            case 2:
                $form = $orderManager->stepTwo($request);
                $template = 'duration.html.twig';
                break;
            case 3:
                $form = $orderManager->stepThree($request);
                $template = 'price.html.twig';
                break;
            default:
                $form = $orderManager->stepOne($request);
                $template = 'order.html.twig';
        }
        dump($this->get('session')->get('step'), $form);

        return $this->render(
            $template,
            [
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/previous", name="app_previous")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function previous()
    {
        $this->get('session')->set('step', 1);
        return $this->redirectToRoute('app_order');
    }
}