<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */
namespace App\tests\Repository;

use App\Entity\Ticket;
use App\Entity\TicketOrder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class TicketRepositoryTest
 */
class TicketRepositoryTest extends KernelTestCase
{
//    /**
//     * @var \Doctrine\ORM\EntityManager
//     */
//    private $entityManager;
//
//    /**
//     * {@inheritDoc}
//     */
//    protected function setUp()
//    {
//        $kernel = self::bootKernel();
//
//        $this->entityManager = $kernel->getContainer()
//            ->get('doctrine')
//            ->getManager();
//    }
//
//    /**
//     * @test
//     *
//     * @throws \Doctrine\ORM\ORMException
//     */
//    public function testSave()
//    {
//        $fakeTicketNumber = md5(uniqid());
//
//        $ticketOrder = new TicketOrder();
//
//        $ticketEntity = new ticket();
//        $ticketEntity->setBirthdate((new \DateTime())->modify('-50 years'));
//        $ticketEntity->setCountry("FR");
//        $ticketEntity->setFirstname("Bob");
//        $ticketEntity->setLastname("Bobino");
//        $ticketEntity->setReducedPrice(false);
//        $ticketEntity->setTicketNumber($fakeTicketNumber);
//        $ticketEntity->setTicketOrder($ticketOrder);
//        $ticketEntity->setTicketPrice(16);
//
//        $this->entityManager
//            ->getRepository(ticket::class)
//            ->save($ticketOrder, $ticketEntity)
//        ;
//
//        $ticket = $this->entityManager
//            ->getRepository(ticket::class)
//            ->findBy(['ticketNumber' => $fakeTicketNumber])
//        ;
//
//        $this->assertCount(1, $ticket);
//    }
//
//    /**
//     * {@inheritDoc}
//     */
//    protected function tearDown()
//    {
//        parent::tearDown();
//
//        $this->entityManager->close();
//        $this->entityManager = null; // avoid memory leaks
//    }
}
