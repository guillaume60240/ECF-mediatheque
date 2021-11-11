<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    
    public function testHome()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        //test uniquement si la page est bien chargée
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAccountIsGranted()
    {
        $client = static::createClient();

        $client->request('GET', '/compte');
        //test le redirection vers la page de connexion
        $this->assertResponseRedirects('/login');
    }

    public function testCalogueIsGranted()
    {
        $client = static::createClient();

        $client->request('GET', '/catalogue');
        //test l'autorisation de l'utilisateur
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}