<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 19/03/2018
 * Time: 15:22
 */

namespace App\Services\Order;

use App\Entity\Ticket;
use App\Repository\TicketOrderRepository;
use App\Validator\Constraints\IsDatePassed;
use App\Validator\Constraints\IsDayTicketsPossible;
use App\Validator\Constraints\IsTooLateForToday;
use App\Validator\IsTicketsAvalaibleValidator;
use Stripe\Charge as StripeCharge;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

/**
 * Class Charge
 */
class Charge
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var TicketOrderRepository
     */
    private $ticketOrderRepository;
    /**
     * @var FlashBagInterface
     */
    private $flash;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var string
     */
    private $stripeKey;

    /**
     * Charge constructor.
     * @param Environment           $twig
     * @param SessionInterface      $session
     * @param TicketOrderRepository $ticketOrderRepository
     * @param FlashBagInterface     $flash
     * @param UrlGeneratorInterface $urlGenerator
     * @param ValidatorInterface    $validator
     * @param string                $stripeKey
     */
    public function __construct(
        Environment $twig,
        SessionInterface $session,
        TicketOrderRepository $ticketOrderRepository,
        FlashBagInterface $flash,
        UrlGeneratorInterface $urlGenerator,
        ValidatorInterface $validator,
        string $stripeKey
    ) {
        $this->session               = $session;
        $this->twig                  = $twig;
        $this->ticketOrderRepository = $ticketOrderRepository;
        $this->flash                 = $flash;
        $this->urlGenerator          = $urlGenerator;
        $this->validator             = $validator;
        $this->stripeKey             = $stripeKey;
    }

    /**
     * @param Request $request
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @return $this|string|RedirectResponse

     */
    public function charge(Request $request)
    {
        $customerEmail = $this->session->get('order')->getMail();

        /** @var Ticket $tickets */
        $tickets = $this->session->get('order')->getTicketCollection();

        // Recheck date
        $violations = $this->validator->validate($this->session->get('order')->getDate(), [
            new IsDatePassed(),
            new IsTooLateForToday(),
        ]);
        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $this->flash->add('errorDate', $violation->getMessage());
            }
            $this->session->set('step', 1);

            RedirectResponse::create(
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        // Recheck duration
        $violations = $this->validator->validate($this->session->get('order')->getDuration(), [
            new IsDayTicketsPossible(),
        ]);
        if (0 !== count($violations)) {
            foreach ($violations as $violation) {
                $this->flash->add('errorDuration', $violation->getMessage());
            }
            $this->session->set('step', 2);

            RedirectResponse::create(
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        // Recheck availability
        $ticketsAvailable = IsTicketsAvalaibleValidator::DAY_BUY_LIMIT - $this->ticketOrderRepository->ticketsForThisDate($this->session->get('order')->getDate());
        if ($ticketsAvailable < count($tickets)) {
            $this->session->set('nbTickets', $ticketsAvailable);
            $this->flash->add('errorTicket', 'ticketsAvailable');
            $this->session->set('step', 3);

            RedirectResponse::create(
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        try {
            Stripe::setApiKey($this->stripeKey);

            StripeCharge::create(
                [
                    "amount"      => $this->session->get('order')->getOrderPrice() * 100,
                    "currency"    => "eur",
                    "source"      => $request->request->get('stripeToken'), // obtained with Stripe.js
                    "description" => "Charge for {$customerEmail}",
                ]
            );
            // Use Stripe's library to make requests...
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
            $err  = $body['error'];

            print('Status is:'.$e->getHttpStatus()."\n");
            print('Type is:'.$err['type']."\n");
            print('Code is:'.$err['code']."\n");
            // param is '' in this case
            print('Param is:'.$err['param']."\n");
            print('Message is:'.$err['message']."\n");
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle'    => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle'    => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle'    => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle'    => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle'    => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle'    => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        }

        return new RedirectResponse(
            $this->urlGenerator->generate('app_success')
        );
    }
}
