<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/03/2018
 * Time: 12:26
 */

namespace App\tests\Controller;

use App\Services\Contact\Contact;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ContactControllerTest
 */
class ContactControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function testContact()
    {
        $client = static::createClient();

        $client->request('GET', '/contact');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
