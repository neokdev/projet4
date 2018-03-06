<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 27/02/2018
 * Time: 09:14
 */

namespace App\Manager;


use App\Entity\Ticket;
use App\Entity\TicketOrder;
use App\Form\ConfirmType;
use App\Form\DurationType;
use App\Form\TicketOrderDateType;
use App\Form\TicketsCollectionType;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;

class OrderManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entity;
    /**
     * @var FormFactoryInterface
     */
    private $factory;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        EntityManagerInterface $entity,
        FormFactoryInterface $factory,
        SessionInterface $session,
        RouterInterface $router
    )
    {
        $this->entity = $entity;
        $this->factory = $factory;
        $this->session = $session;
        $this->router = $router;
    }

    public function stepOne(Request $request)
    {
        $order = $this->session->has('order') ? $this->session->get('order') : new TicketOrder();
        $form = $this->factory->create(TicketOrderDateType::class, $order)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            $order->setOrderDate(new \DateTime());
            $this->session->set('order', $order);
            $this->session->set('step', 2);

            RedirectResponse::create(
                $this->router->generate('app_order')
            )->send();
        }
        return $form->createView();
    }

    public function stepTwo(Request $request)
    {
        $order = $this->session->get('order');
        $form = $this->factory->create(DurationType::class, $order)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            $this->session->set('order', $order);
            $this->session->set('step', 3);

            RedirectResponse::create(
                $this->router->generate('app_order')
            )->send();
        }
        return $form->createView();
    }
    public function stepThree(Request $request)
    {
        $ticket = new Ticket();
        $order = $this->session->get('order');
        $form = $this->factory->create(TicketsCollectionType::class, $order)
            ->handleRequest($request);
        $ticketForm = $this->factory->create(TicketType::class, $ticket)
            ->handleRequest($request);

//        if ($request->isMethod('POST')) {
//            $ticketForm->submit($request->request->get($ticketForm->getName()));
//            dump($ticketForm);die();
//        }
//
        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            $this->session->set('order', $order);
            $this->session->set('step', 4);

            RedirectResponse::create(
                $this->router->generate('app_order')
            )->send();
        }
        return $form->createView();
    }

    public function stepFour(Request $request)
    {
        $order = $this->session->get('order');
        $form = $this->factory->create(ConfirmType::class, $order)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            $this->session->set('order', $order);
            $this->session->set('step', 5);

            RedirectResponse::create(
                $this->router->generate('app_order')
            )->send();
        }
        return $form->createView();
    }
}