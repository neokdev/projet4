<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 29/01/2018
 * Time: 21:00
 */

namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class OrderControllerTest
 */
class OrderControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function testOrder()
    {
        $client = static::createClient();

        $client->request('GET', '/order');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
