<?php

namespace AppBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * WebTestCase
 */
class WebTestCase extends BaseWebTestCase
{

    /**
     * Handle the login in the tests
     *
     * @param Client $client
     * @param string $username
     * @param string $password
     */
    protected function login(Client $client, $username, $password)
    {
        $crawler = $client->request('GET', '/login');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The login page is successful');
        
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Connexion")')->count());

        $form = $crawler->selectButton('Connexion')->form();

        $crawler = $client->submit($form, array('_username' => $username, '_password' => $password));
    }

    /**
     * logout the user
     *
     * @param Client $client
     */
    protected function logout(Client $client)
    {
        $crawler = $client->request('GET', '/logout');

        $crawler = $client->followRedirect();
    }

}
