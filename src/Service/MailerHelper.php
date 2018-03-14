<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/03/2018
 * Time: 13:53
 */

namespace App\Service;


use App\Entity\Ticket;
use App\Entity\TicketOrder;

class MailerHelper
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * MailerHelper constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param TicketOrder $order
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function orderMail(TicketOrder $order, $tickets)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('admin@projet4.nekbot.com')
            ->setTo($order->getMail())
            ->setBody(
                $this->twig->render(
                    'emails/order.html.twig', [
                        'order' => $order,
                        'tickets' => $tickets
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}