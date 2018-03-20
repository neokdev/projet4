<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 20/03/2018
 * Time: 09:34
 */

namespace App\Services\Contact;

use App\Entity\Contact as ContactEntity;
use App\Form\ContactType;
use App\Manager\ContactManager;
use App\Services\MailerHelper;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

/**
 * Class Contact
 */
class Contact
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var MailerHelper
     */
    private $mailerHelper;
    /**
     * @var ContactManager
     */
    private $contact;

    /**
     * Contact constructor.
     * @param Environment          $twig
     * @param FormFactoryInterface $factory
     * @param MailerHelper         $mailerHelper
     * @param ContactManager       $contact
     */
    public function __construct(
        Environment $twig,
        FormFactoryInterface $factory,
        MailerHelper $mailerHelper,
        ContactManager $contact
    ) {
        $this->factory = $factory;
        $this->twig = $twig;
        $this->mailerHelper = $mailerHelper;
        $this->contact = $contact;
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
    public function contact(Request $request)
    {
        $contact = new ContactEntity();

        $form = $this->factory->create(ContactType::class, $contact)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contact->writeContact($contact);

            $this->mailerHelper->contactMail($contact);

//            return $this->render('Emails/contact.html.twig', [
//                'contact' => $contact,
//            ]);
        }

        return $this->twig->render('Contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
