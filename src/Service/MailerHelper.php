<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/03/2018
 * Time: 13:53
 */

namespace App\Service;


use App\Entity\Contact;
use App\Entity\TicketOrder;
use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

class MailerHelper
{
    CONST ADMIN_EMAIL = 'admin@projet4.nekbot.com';

    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * MailerHelper constructor.
     * @param Swift_Mailer $mailer
     * @param Twig_Environment $twig
     */
    public function __construct(Swift_Mailer $mailer, Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param TicketOrder $order
     * @param $tickets
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function orderMail(TicketOrder $order, $tickets)
    {
        $message = new Swift_Message('Billets du Musée du Louvre');

        $bootstrapCss = "https://bootswatch.com/4/united/bootstrap.min.css";
        $stylesCss = "css/styles.css";

        $templateFiles = [
            'bootstrapCss' => $message->embed(\Swift_EmbeddedFile::fromPath($bootstrapCss)),
            'stylesCss' => $message->embed(\Swift_EmbeddedFile::fromPath($stylesCss)),
        ];

        $message
            ->setFrom(self::ADMIN_EMAIL)
            ->setTo($order->getMail())
            ->setBody(
                $this->twig->render(
                    'emails/order.html.twig', [
                        'order' => $order,
                        'tickets' => $tickets,
                        'files' => $templateFiles,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    /**
     * @param Contact $contact
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function contactMail(Contact $contact)
    {
        $message = (new Swift_Message($contact->getMessageType()))
            ->setFrom($contact->getEmail())
            ->setTo(self::ADMIN_EMAIL)
            ->setBody(
                $this->twig->render(
                    'Emails/contact.html.twig', [
                        'contact' => $contact,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}