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
use App\Form\Type\DurationType;
use App\Form\Type\TicketOrderDateType;
use App\Form\WizardType;
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

            return new RedirectResponse(
                $this->router->generate('app_order')
            );
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

            return new RedirectResponse(
                $this->router->generate('app_order')
            );
        }
        return $form->createView();
    }
    public function stepThree(Request $request)
    {
        $ticket = new Ticket();
        $order = $this->session->get('order');
        $form = $this->factory->create(WizardType::class, $order)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            $this->session->set('order', $order);
            $this->session->set('step', 4);

            return new RedirectResponse(
                $this->router->generate('app_order')
            );
        }
        return $form->createView();
    }
}