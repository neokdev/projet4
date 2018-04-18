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
 * Class HomeController
 */
class HomeControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function testHomepage()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function testLangFr()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        $link    = $crawler
            ->filter('a:contains("Français")')
            ->link();

        $crawler = $client->click($link);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
