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
use Symfony\Component\HttpFoundation\Session\SessionInterface;


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
     * @return Response
     */
    public function index(Request $request, SessionInterface $session)
    {
        $form = null;
        $template = null;
        switch ($this->get('session')->get('step')) {
            case 1:
                $form = $this->orderManager->stepOne($request);
                $template = "Order/_date.html.twig";
                $cardtitle = "card_title_date";
                break;
            case 2:
                $form = $this->orderManager->stepTwo($request);
                $template = 'Order/_duration.html.twig';
                $cardtitle = "card_title_duration";
                break;
            case 3:
                $form = $this->orderManager->stepThree($request);
                $template = 'Order/_price.html.twig';
                $cardtitle = "card_title_price";
                break;
            case 4:
                $form = $this->orderManager->stepFour($request);
                $template = 'Order/_confirm.html.twig';
                $cardtitle = "card_title_confirm";
                break;
            default:
                $form = $this->orderManager->stepOne($request);
                $template = 'Order/_date.html.twig';
                $cardtitle = "card_title_date";
        }

        return $this->render(
            $template,
            [
                'tickets' => $session->get('tickets'),
                'cardtitle' => $cardtitle,
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
    }

    /**
     * @Route("/reset", name="app_reset")
     */
    public function reset()
    {
        $this->get('session')->set('step', 1);
        $this->get('session')->set('order', null);
        return $this->redirectToRoute('app_order');
    }
}