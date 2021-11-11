<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    public function testLoginDisplay()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('h2:contains("Merci de vous connecter")')->count());
        $this->assertEquals(1, $crawler->filter('input[type="email"]')->count());
        $this->assertEquals(1, $crawler->filter('input[type="password"]')->count());
        $this->assertEquals(1, $crawler->filter('button[type="submit"]')->count());
        $this->assertSelectorNotExists('div.alert.alert-danger');
    }

    public function testBadLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Valider')->form();
        $form['email'] = 'test@test.com';
        $form['password'] = 'fakepassword';

        $client->submit($form);

        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('div.alert.alert-danger');
    }

    public function testGoodLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Valider')->form();
        $form['email'] = 'test9@test.fr';
        $form['password'] = 'truepass';

        $client->submit($form);

        $this->assertResponseRedirects('/compte');
    }
}