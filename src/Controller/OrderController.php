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
use App\Service\DateHelper;
use App\Service\MailerHelper;
use Locale;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;



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
     * @param SessionInterface $session
     * @param RouterInterface $router
     * @return Response
     */
    public function index(
        Request $request,
        SessionInterface $session,
        RouterInterface $router)
    {
        $form = null;
        $template = null;
        switch ($this->get('session')->get('step')) {
            case 1:
                $form = $this->orderManager->stepOne($request);
                $template = "Order/_date.html.twig";
                $cardTitle = "cardTitleDate";
                break;
            case 2:
                $form = $this->orderManager->stepTwo($request);
                $template = 'Order/_duration.html.twig';
                $cardTitle = "cardTitleDuration";
                break;
            case 3:
                $form = $this->orderManager->stepThree($request);
                $template = 'Order/_price.html.twig';
                $cardTitle = "cardTitlePrice";
                break;
            case 4:
                $form = $this->orderManager->stepFour($request);
                $template = 'Order/_mail.html.twig';
                $cardTitle = "cardTitleMail";
                break;
            case 5:
                RedirectResponse::create(
                $router->generate('app_checkout')
            )->send();
                break;
            default:
                $form = $this->orderManager->stepOne($request);
                $template = 'Order/_date.html.twig';
                $cardTitle = "cardTitleDate";
        }

        return $this->render(
            $template,
            [
                'order' => $session->get('order'),
                'tickets' => $session->get('tickets'),
                'cardTitle' => $cardTitle,
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

    /**
     * @Route("/checkout", name="app_checkout")
     * @param SessionInterface $session
     * @param DateHelper $helper
     * @return Response
     */
    public function checkout(SessionInterface $session, DateHelper $helper)
    {
        setlocale(LC_TIME, Locale::getDefault());
        $date = strftime("%A %e %B %Y", $helper->getSelectedDate()->getTimestamp());
        return $this->render('Order/_checkout.html.twig', [
            'date' => $date,
            'cardTitle' => "cardTitleConfirm",
            'order' => $session->get('order'),
            'tickets' => $session->get('tickets'),
            ]);
    }

    /**
     * @Route(
     *     "/charge",
     *     name="app_charge",
     *     methods={"POST"}
     * )
     * @param Request $request
     * @param SessionInterface $session
     * @return RedirectResponse|Response
     */
    public function charge(Request $request, SessionInterface $session)
    {
        $customerEmail = $session->get('order')->getMail();

        try {
            Stripe::setApiKey("sk_test_XjQG5GSatz3GILddd9hzULuh");

            Charge::create(array(
                "amount" => $session->get('order')->getOrderPrice() *100,
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'), // obtained with Stripe.js
                "description" => "Charge for $customerEmail"
            ));
            // Use Stripe's library to make requests...
        } catch(\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];

            print('Status is:' . $e->getHttpStatus() . "\n");
            print('Type is:' . $err['type'] . "\n");
            print('Code is:' . $err['code'] . "\n");
            // param is '' in this case
            print('Param is:' . $err['param'] . "\n");
            print('Message is:' . $err['message'] . "\n");
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            return $this->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage()
            ]);
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return $this->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage()
            ]);
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return $this->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage()
            ]);
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return $this->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage()
            ]);
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return $this->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage()
            ]);
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return $this->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage()
            ]);
        }

        return $this->redirectToRoute('app_success');
    }

    /**
     * @Route("/success", name="app_success")
     * @param SessionInterface $session
     * @param MailerHelper $helper
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function success(SessionInterface $session, MailerHelper $helper)
    {
        $order = $session->get('order');
        $tickets = $order->getTicketCollection();

        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        /** @var Ticket $ticket */
        foreach ($tickets as $ticket) {
            $ticket->setTicketOrder($order);
            $em->persist($ticket);
        }
        $em->flush();

        $helper->orderMail($order, $tickets);

//        return $this->render('Emails/order.html.twig', [
//            'cardTitle' => "cardTitleSuccess",
//            'order' => $order,
//            'tickets' => $tickets,
//        ]);

//        $this->orderManager->clearSessionVars();

        return $this->render('Order/_success.html.twig', [
            'cardTitle' => "cardTitleSuccess",
            'order' => $order,
        ]);
    }
}