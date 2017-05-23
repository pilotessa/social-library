<?php

namespace LibraryBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/book');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/book/view/{id}');
    }

}
