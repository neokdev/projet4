<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 29/01/2018
 * Time: 21:00
 */

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\TicketOrder;
use App\Form\WizardType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class TestController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     */
    public function index(Request $request)
    {
        $order = new TicketOrder();

        $ticket1 = new Ticket();
        $ticket2 = new Ticket();
        $ticket1->setTicketNumber('548962');
//        dump($ticket1);die;
        $order->addTicket($ticket1);


        $wizard = $this->createForm(WizardType::class, $order);

        $wizard->handleRequest($request);

        if ($wizard->isSubmitted() && $form->isValid()) {
            // ... maybe do some form processing, like saving the Task and Tag objects
        }

        return $this->render('test.html.twig', [
            'form' => $wizard->createView(),
        ]);
    }
}