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
use App\Repository\ContactRepository;
use App\Services\MailerHelper;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
     * @var FlashBagInterface
     */
    private $flash;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * Contact constructor.
     * @param Environment           $twig
     * @param FlashBagInterface     $flash
     * @param FormFactoryInterface  $factory
     * @param MailerHelper          $mailerHelper
     * @param UrlGeneratorInterface $urlGenerator
     * @param ContactRepository     $contactRepository
     */
    public function __construct(
        Environment $twig,
        FlashBagInterface $flash,
        FormFactoryInterface $factory,
        MailerHelper $mailerHelper,
        UrlGeneratorInterface $urlGenerator,
        ContactRepository $contactRepository
    ) {
        $this->factory           = $factory;
        $this->twig              = $twig;
        $this->mailerHelper      = $mailerHelper;
        $this->flash             = $flash;
        $this->urlGenerator      = $urlGenerator;
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param Request $request
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return $this|string
     */
    public function contact(Request $request)
    {
        $contact = new ContactEntity();

        $form = $this->factory->create(ContactType::class, $contact)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactRepository->save($contact);

            $this->mailerHelper->contactMail($contact);

            $this->flash->add('success', 'contactSuccess');

            return RedirectResponse::create(
                $this->urlGenerator->generate('app_homepage')
            )->send();
        }

        return $this->twig->render('Contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
