<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 19/03/2018
 * Time: 15:32
 */

namespace App\Services\Order;

use App\Manager\OrderManager;
use App\Services\DateHelper;
use App\Services\MailerHelper;
use App\Services\SessionHelper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * Class Success
 */
class Success
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var MailerHelper
     */
    private $mailerHelper;
    /**
     * @var OrderManager
     */
    private $order;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var SessionHelper
     */
    private $sessionHelper;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * Success constructor.
     * @param Environment           $twig
     * @param SessionInterface      $session
     * @param OrderManager          $order
     * @param MailerHelper          $mailerHelper
     * @param SessionHelper         $sessionHelper
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        Environment $twig,
        SessionInterface $session,
        OrderManager $order,
        MailerHelper $mailerHelper,
        SessionHelper $sessionHelper,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->session = $session;
        $this->mailerHelper = $mailerHelper;
        $this->order = $order;
        $this->twig = $twig;
        $this->sessionHelper = $sessionHelper;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string|RedirectResponse
     */
    public function success()
    {
        if ($this->session->get('step') < 5) {
            return RedirectResponse::create(
                $this->urlGenerator->generate('app_order')
            )->send();
        }

        $order = $this->session->get('order');

        date_default_timezone_set(DateHelper::TIMEZONE);
        $order->setOrderDate(new \DateTime());

        $tickets = $order->getTicketCollection();

        $this->order->writeOrder($order, $tickets);

        $this->mailerHelper->orderMail($order, $tickets);

        $this->sessionHelper->clearSessionVars();

        return $this->twig->render('Order/_success.html.twig', [
            'cardTitle' => "cardTitleSuccess",
            'order' => $order,
        ]);
    }
}
