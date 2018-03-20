<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 27/02/2018
 * Time: 09:14
 */

namespace App\Manager;

use App\Entity\Contact;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ContactManager
 */
class ContactManager
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * OrderManager constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
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
