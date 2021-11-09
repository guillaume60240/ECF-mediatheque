<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testRegisterDisplay()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/#register');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(4, $crawler->filter('input[type="text"]')->count());
        $this->assertEquals(1, $crawler->filter('input[type="email"]')->count());
        $this->assertEquals(2, $crawler->filter('input[type="password"]')->count());
        $this->assertEquals(1, $crawler->filter('input[type="checkbox"]')->count());
        $this->assertEquals(1, $crawler->filter('button[type="submit"]')->count());  
    }

    public function testSubmitRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/#register');

        $form = $crawler->selectButton('Valider')->form();
        $form['register[name]'] = 'testname';
        $form['register[firstname]'] = 'testfirstname';
        $form['register[email]'] = 'test@test.com';
        $form['register[birthday][day]'] = '12';
        $form['register[birthday][month]'] = '1';
        $form['register[birthday][year]'] = '2000';
        $form['register[street]'] = 'test street';
        $form['register[city]'] = 'test city';
        $form['register[password][first]'] = '00000';
        $form['register[password][second]'] = '00000';
        $form['register[checkbox]'] = true;

        $client->submit($form);

        $this->assertResponseRedirects('/valider-mon-mail');
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}