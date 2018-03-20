<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 19/03/2018
 * Time: 15:22
 */

namespace App\Services\Order;

use Stripe\Charge as StripeCharge;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
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
     * @var RouterInterface
     */
    private $router;

    /**
     * Charge constructor.
     * @param Environment      $twig
     * @param RouterInterface  $router
     * @param SessionInterface $session
     */
    public function __construct(
        Environment $twig,
        RouterInterface $router,
        SessionInterface $session
    ) {
        $this->session = $session;
        $this->twig = $twig;
        $this->router = $router;
    }

    /**
     * @param Request $request
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return $this|string
     */
    public function charge(Request $request)
    {
        $customerEmail = $this->session->get('order')->getMail();

        try {
            Stripe::setApiKey("sk_test_XjQG5GSatz3GILddd9hzULuh");

            StripeCharge::create(
                [
                "amount" => $this->session->get('order')->getOrderPrice() *100,
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'), // obtained with Stripe.js
                "description" => "Charge for $customerEmail",
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
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            return $this->twig->render('Order/_fail.html.twig', [
                'cardTitle' => "cardTitleFail",
                'errorMessage' => $e->getMessage(),
            ]);
        }

        return RedirectResponse::create(
            $this->router->generate('app_success')
        )->send();
    }
}
