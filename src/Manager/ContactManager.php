<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 27/02/2018
 * Time: 09:14
 */

namespace App\Manager;

use App\Entity\Contact;
use App\Services\IdHelper;
use App\Services\PriceHelper;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ContactManager
 */
class ContactManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entity;
    /**
     * @var FormFactoryInterface
     */
    private $factory;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var PriceHelper
     */
    private $helper;
    /**
     * @var IdHelper
     */
    private $idHelper;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * OrderManager constructor.
     * @param EntityManagerInterface $entity
     * @param FormFactoryInterface   $factory
     * @param SessionInterface       $session
     * @param UrlGeneratorInterface  $urlGenerator
     * @param PriceHelper            $helper
     * @param IdHelper               $idHelper
     * @param ManagerRegistry        $registry
     */
    public function __construct(
        EntityManagerInterface $entity,
        FormFactoryInterface $factory,
        SessionInterface $session,
        UrlGeneratorInterface $urlGenerator,
        PriceHelper $helper,
        IdHelper $idHelper,
        ManagerRegistry $registry
    ) {
        $this->entity = $entity;
        $this->factory = $factory;
        $this->session = $session;
        $this->helper = $helper;
        $this->idHelper = $idHelper;
        $this->urlGenerator = $urlGenerator;
        $this->registry = $registry;
    }

    /**
     * @param Contact $contact
     */
    public function writeContact(Contact $contact)
    {
        $em = $this->registry->getManager();
        $em->persist($contact);
        $em->flush();
    }
}
