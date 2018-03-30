<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 27/02/2018
 * Time: 09:14
 */

namespace App\Manager;

use App\Entity\Contact;
use App\Repository\ContactRepository;

/**
 * Class ContactManager
 */
class ContactManager
{
    /**
     * @var ContactRepository
     */
    private $contactRepository;

    /**
     * ContactManager constructor.
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param Contact $contact
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function writeContact(Contact $contact)
    {
        $this->contactRepository->save($contact);
    }
}
