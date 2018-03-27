<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 13/03/2018
 * Time: 13:53
 */

namespace App\Services;

use App\Entity\Contact;
use App\Entity\Ticket;
use App\Entity\TicketOrder;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Translation\TranslatorInterface;
use Twig_Environment;

/**
 * Class MailerHelper
 */
class MailerHelper
{
    const ADMIN_EMAIL = 'admin@projet4.nekbot.com';

    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var Twig_Environment
     */
    private $twig;
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var string
     */
    private $pathToLogo;

    /**
     * MailerHelper constructor.
     * @param Swift_Mailer        $mailer
     * @param Twig_Environment    $twig
     * @param TranslatorInterface $translator
     * @param string              $pathToLogo
     */
    public function __construct(
        Swift_Mailer $mailer,
        Twig_Environment $twig,
        TranslatorInterface $translator,
        string $pathToLogo
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->translator = $translator;
        $this->pathToLogo = $pathToLogo;
    }

    /**
     * @param TicketOrder $order
     * @param Ticket      $tickets
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function orderMail(TicketOrder $order, $tickets)
    {
        $message = new Swift_Message('Billets du Musée du Louvre');

        $message
            ->setFrom(self::ADMIN_EMAIL)
            ->setTo($order->getMail())
            ->setBody(
                $this->twig->render(
                    'Emails/order.html.twig',
                    [
                        'order' => $order,
                        'tickets' => $tickets,
                        'logo' => $message->embed(\Swift_Image::fromPath($this->pathToLogo)),
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    /**
     * @param Contact $contact
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function contactMail(Contact $contact)
    {
        $message = new Swift_Message("[".$this->translator->trans($contact->getMessageType())."] ".$contact->getSubject());

        $message
            ->setFrom($contact->getEmail())
            ->setTo(self::ADMIN_EMAIL)
            ->setBody(
                $this->twig->render(
                    'Emails/contact.html.twig',
                    [
                        'contact' => $contact,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
