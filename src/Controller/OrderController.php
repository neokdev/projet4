<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 29/01/2018
 * Time: 21:00
 */

namespace App\Controller;

use App\Entity\Ticket;
use App\Manager\OrderManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OrderController extends AbstractController
{
    /**
     * @var OrderManager
     */
    private $orderManager;

    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }
    /**
     * @Route("/order", name="app_order")
     * @param Request $request
     * @param OrderManager $orderManager
     * @return Response
     */
    public function index(Request $request)
    {
        $form = null;
        $template = null;
        switch ($this->get('session')->get('step')) {
            case 1:
                $form = $this->orderManager->stepOne($request);
                $template = 'order.html.twig';
                break;
            case 2:
                $form = $this->orderManager->stepTwo($request);
                $template = 'duration.html.twig';
                break;
            case 3:
                $form = $this->orderManager->stepThree($request);
                $template = 'price.html.twig';
                break;
            default:
                $form = $this->orderManager->stepOne($request);
                $template = 'order.html.twig';
        }
        dump($this->get('session')->get('step'), $form, get_class($form));

        //Prevent to return a RedirectResponse
        if (get_class($form) == 'Symfony\Component\HttpFoundation\RedirectResponse') {
            return $this->redirectToRoute('app_order');
        }

        return $this->render(
            $template,
            [
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/previous", name="app_previous")
     */
    public function previous()
    {
        $this->get('session')->set('step', $this->get('session')->get('step')-1);
        return $this->redirectToRoute('app_order');
        ///!\ Step number hardcoded
//        $this->get('session')->set('step', 1);
//        return $this->redirectToRoute('app_order');
    }
}