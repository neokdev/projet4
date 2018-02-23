<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 29/01/2018
 * Time: 21:00
 */

namespace App\Controller;

use App\Entity\TicketOrder;
use App\Form\Type\DurationType;
use App\Form\Type\TicketOrderDateType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class TestController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $order = new TicketOrder();
        $date = $this->createForm(TicketOrderDateType::class, $order);

        $date->handleRequest($request);

        if ($date->isSubmitted() && $date->isValid()) {

            $dateorder = $date['date']->getData();
            $order->setDate($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($order);

            $this->addFlash('success', 'Date OK');

            return $this->redirectToRoute('app_duration');
        }

        return $this->render('test.html.twig', [
            'form' => $date->createView(),
        ]);
    }

    /**
     * @Route("/duration", name="app_duration")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function duration(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $duration = $this->createForm(DurationType::class);
        $duration->handleRequest($request);

        return $this->render('test.html.twig', [
           'form' => $duration
        ]);
    }
    /**
     * @Route("/test", name="app_previous")
     */
    public function previous(Request $request)
    {
        return $this->redirectToRoute('app_test');
    }
}