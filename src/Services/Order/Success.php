<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 19/03/2018
 * Time: 15:32
 */

namespace App\Services\Order;

use App\Manager\OrderManager;
use App\Services\MailerHelper;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
     * Success constructor.
     * @param Environment      $twig
     * @param SessionInterface $session
     * @param OrderManager     $order
     * @param MailerHelper     $mailerHelper
     */
    public function __construct(
        Environment $twig,
        SessionInterface $session,
        OrderManager $order,
        MailerHelper $mailerHelper
    ) {
        $this->session = $session;
        $this->mailerHelper = $mailerHelper;
        $this->order = $order;
        $this->twig = $twig;
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return string
     */
    public function success()
    {
        $order = $this->session->get('order');
        $tickets = $order->getTicketCollection();

        $this->order->writeOrder($order, $tickets);

        $this->mailerHelper->orderMail($order, $tickets);

//        return $this->render('Emails/order.html.twig', [
//            'cardTitle' => "cardTitleSuccess",
//            'order' => $order,
//            'tickets' => $tickets,
//        ]);

//        $this->orderManager->clearSessionVars();

        return $this->twig->render('Order/_success.html.twig', [
            'cardTitle' => "cardTitleSuccess",
            'order' => $order,
        ]);
    }
}
