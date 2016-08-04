<?php

namespace DataBaseBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FormControllerTest extends WebTestCase
{
    public function testSimpleform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/simpleForm');
    }

    public function testCustomerform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/customerForm');
    }

    public function testOrderform()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/orderForm');
    }

}
