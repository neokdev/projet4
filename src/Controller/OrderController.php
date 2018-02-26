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
use App\Form\Type\DurationType;
use App\Form\Type\TicketOrderDateType;
use App\Form\WizardType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\DataCollector\DoctrineDataCollector;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OrderController extends AbstractController
{
    /**
     * /**
     * @Route("/order", name="app_order")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $order = new TicketOrder();
        $ticket = new Ticket();

        $date = $this->createForm(TicketOrderDateType::class, $order);
        $duration = $this->createForm(DurationType::class, $order);
        $ticketHolder = $this->createForm(WizardType::class, $order);
        $date->handleRequest($request);
        $duration->handleRequest($request);
        $ticketHolder->handleRequest($request);

        if ($date->isSubmitted() && $date->isValid()) {

            $selectedDate = $date['date']->getData();
            $order->setDate($selectedDate);

            $orderDate = new \DateTime();

            $order->setOrderDate($orderDate);
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);

            $this->addFlash('success', 'Date OK');

            return $this->render('duration.html.twig', [
                'order' => $order,
                'form' => $duration->createView()
            ]);
        }

        if ($duration->isSubmitted() && $date->isValid()) {
            $selectedDuration = $duration['duration']->getData();
            $order->setDuration($selectedDuration);

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);

            $this->addFlash('success', 'Date OK');

            return $this->render('duration.html.twig', [
                'order' => $order,
                'form' => $ticketHolder->createView()
            ]);
        }

        return $this->render('order.html.twig', [
            'order' => $order,
            'form' => $date->createView(),
        ]);
    }

    /**
     * @Route("/test")
     */
    public function duration()
    {
    }
    /**
     * @Route("/order", name="app_previous")
     */
    public function previous()
    {
        return $this->redirectToRoute('app_order');
    }
}