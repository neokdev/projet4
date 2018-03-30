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
use App\Repository\TicketOrderRepository;
use App\Repository\TicketRepository;
use App\Services\IdHelper;
use App\Services\PriceHelper;
use App\Validator\IsTicketsAvalaibleValidator;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class OrderManager
 */
class OrderManager
{
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
     * @var TicketOrderRepository
     */
    private $ticketOrderRepository;
    /**
     * @var FlashBagInterface
     */
    private $flash;
    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    /**
     * OrderManager constructor.
     * @param FormFactoryInterface  $factory
     * @param SessionInterface      $session
     * @param UrlGeneratorInterface $urlGenerator
     * @param PriceHelper           $helper
     * @param IdHelper              $idHelper
     * @param ManagerRegistry       $registry
     * @param FlashBagInterface     $flash
     * @param TicketOrderRepository $ticketOrderRepository
     * @param TicketRepository      $ticketRepository
     */
    public function __construct(
        FormFactoryInterface $factory,
        SessionInterface $session,
        UrlGeneratorInterface $urlGenerator,
        PriceHelper $helper,
        IdHelper $idHelper,
        ManagerRegistry $registry,
        FlashBagInterface $flash,
        TicketOrderRepository $ticketOrderRepository,
        TicketRepository $ticketRepository
    ) {
        $this->factory = $factory;
        $this->session = $session;
        $this->helper = $helper;
        $this->idHelper = $idHelper;
        $this->urlGenerator = $urlGenerator;
        $this->registry = $registry;
        $this->ticketOrderRepository = $ticketOrderRepository;
        $this->flash = $flash;
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\FormView|RedirectResponse
     */
    public function stepOne(Request $request)
    {
        $order = $this->session->has('order') ? $this->session->get('order') : new TicketOrder();
        $form = $this->factory->create(TicketOrderDateType::class, $order)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            $this->session->set('order', $order);
            $this->session->set('step', 2);

            return RedirectResponse::create(
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        return $form->createView();
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\FormView|RedirectResponse
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

            return RedirectResponse::create(
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        return $form->createView();
    }

    /**
     * @param Request $request
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return \Symfony\Component\Form\FormView|RedirectResponse
     */
    public function stepThree(Request $request)
    {
        $order = $this->session->get('order');
        $form = $this->factory->create(TicketsCollectionType::class, $order)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();

            /** @var Ticket $tickets */
            $tickets = $order->getTicketCollection();

            //Check availability
            $ticketsAvailable = IsTicketsAvalaibleValidator::DAY_BUY_LIMIT - $this->ticketOrderRepository->ticketsForThisDate($this->session->get('order')->getDate());
            if ($ticketsAvailable < count($tickets)) {
                $this->session->set('nbTickets', $ticketsAvailable);
                $this->flash->add('errorTicket', 'ticketsAvailable');

                return RedirectResponse::create(
                    $this->urlGenerator->generate('app_order')
                )->send();
            }

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

            $this->session->set('step', 4);

            return RedirectResponse::create(
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        return $form->createView();
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\Form\FormView|RedirectResponse
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

            return RedirectResponse::create(
                $this->urlGenerator->generate('app_checkout')
            )->send();
        }

        return $form->createView();
    }

    /**
     * @param TicketOrder $order
     * @param Ticket      $tickets
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function writeOrder(TicketOrder $order, $tickets): void
    {
        $this->ticketOrderRepository->save($order);
        $this->ticketRepository->save($order, $tickets);
    }
}
