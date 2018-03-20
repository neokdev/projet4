<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 19/03/2018
 * Time: 12:58
 */

namespace App\Services\Order;

use App\Manager\OrderManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * Class Pages
 */
class Pages
{
    /**
     * @var OrderManager
     */
    private $orderManager;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var Environment
     */
    private $twig;

    /**
     * Pages constructor.
     * @param Environment      $twig
     * @param OrderManager     $orderManager
     * @param SessionInterface $session
     * @param RouterInterface  $router
     */
    public function __construct(
        Environment $twig,
        OrderManager $orderManager,
        SessionInterface $session,
        RouterInterface $router
    ) {
        $this->orderManager = $orderManager;
        $this->session = $session;
        $this->router = $router;
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string
     */
    public function step(Request $request)
    {
        $form = null;
        $template = null;
        switch ($this->session->get('step')) {
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
                    $this->router->generate('app_checkout')
                )->send();
                $cardTitle = null;
                break;
            default:
                $form = $this->orderManager->stepOne($request);
                $template = 'Order/_date.html.twig';
                $cardTitle = "cardTitleDate";
        }

        return $this->twig->render(
            $template,
            [
                'order' => $this->session->get('order'),
                'tickets' => $this->session->get('tickets'),
                'cardTitle' => $cardTitle,
                'form' => $form,
            ]
        );
    }
}
