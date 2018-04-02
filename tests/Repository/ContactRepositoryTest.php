<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */
namespace App\tests\Repository;

use App\Entity\Contact;
use Faker\Provider\Lorem;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ContactRepositoryTest
 */
class ContactRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @test
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function testSave()
    {
        $fakeText = Lorem::sentence(255);

        $contactEntity = new Contact();
        $contactEntity->setSubject('Subject');
        $contactEntity->setMessageType('noMailReceived');
        $contactEntity->setMessageText($fakeText);
        $contactEntity->setEmail('admin@projet4.nekbot.com');

        $this->entityManager
            ->getRepository(Contact::class)
            ->save($contactEntity)
        ;

        $contact = $this->entityManager
            ->getRepository(Contact::class)
            ->findBy(['messageText' => $fakeText])
        ;

        $this->assertCount(1, $contact);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}
