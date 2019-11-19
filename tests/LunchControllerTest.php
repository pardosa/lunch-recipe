<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LunchControllerTest extends WebTestCase
{
    public function testLunch()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/lunch');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
