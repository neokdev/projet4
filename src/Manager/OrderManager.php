<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 27/02/2018
 * Time: 09:14
 */

namespace App\Manager;

use App\Entity\Contact;
use App\Entity\Ticket;
use App\Entity\TicketOrder;
use App\Form\ConfirmType;
use App\Form\DurationType;
use App\Form\TicketOrderDateType;
use App\Form\TicketsCollectionType;
use App\Services\IdHelper;
use App\Services\PriceHelper;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class OrderManager
 */
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
     * @var PriceHelper
     */
    private $helper;
    /**
     * @var IdHelper
     */
    private $idHelper;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * OrderManager constructor.
     * @param EntityManagerInterface $entity
     * @param FormFactoryInterface   $factory
     * @param SessionInterface       $session
     * @param UrlGeneratorInterface  $urlGenerator
     * @param PriceHelper            $helper
     * @param IdHelper               $idHelper
     * @param ManagerRegistry        $registry
     */
    public function __construct(
        EntityManagerInterface $entity,
        FormFactoryInterface $factory,
        SessionInterface $session,
        UrlGeneratorInterface $urlGenerator,
        PriceHelper $helper,
        IdHelper $idHelper,
        ManagerRegistry $registry
    ) {
        $this->entity = $entity;
        $this->factory = $factory;
        $this->session = $session;
        $this->helper = $helper;
        $this->idHelper = $idHelper;
        $this->urlGenerator = $urlGenerator;
        $this->registry = $registry;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\FormView
     */
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
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        return $form->createView();
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\FormView
     */
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
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        return $form->createView();
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\FormView
     */
    public function stepThree(Request $request)
    {
        $order = $this->session->get('order');
        $form = $this->factory->create(TicketsCollectionType::class, $order)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();

            $this->session->set('step', 4);

            /** @var Ticket $tickets */
            $tickets = $order->getTicketCollection();
            $this->session->set('tickets', $order->getTicketCollection());
            $totalPrice = 0;
            /** @var Ticket $ticket */
            foreach ($tickets as $ticket) {
                $ticket->setTicketNumber($this->idHelper->createId());
                $price = $this->helper->calculatePrice($ticket->getBirthdate(), $ticket->getReducedPrice());
                $ticket->setTicketPrice($price);
                $totalPrice += $price;
            }
            if ($order->getDuration() !== true) {
                $totalPrice = $totalPrice/2;
            }
            $order->setOrderPrice($totalPrice);
            $order->setOrderNumber($this->idHelper->createId());

            $this->session->set('order', $order);

            RedirectResponse::create(
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        return $form->createView();
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\FormView
     */
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
                $this->urlGenerator->generate('app_checkout')
            )->send();
        }

        return $form->createView();
    }

    /**
     * @param TicketOrder $order
     * @param Ticket      $tickets
     */
    public function writeOrder(TicketOrder $order, $tickets): void
    {
        $em = $this->registry->getManager();
        $em->persist($order);
        /** @var Ticket $ticket */
        foreach ($tickets as $ticket) {
            $ticket->setTicketOrder($order);
            $em->persist($ticket);
        }
        $em->flush();
    }

    /**
     *
     */
    public function clearSessionVars(): void
    {
        $this->session->remove('step');
        $this->session->remove('order');
        $this->session->remove('ticket');
        $this->session->remove('tickets');
    }
}
