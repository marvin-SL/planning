<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use AppBundle\Tests\WebTestCase;

/**
 *  test on teacher
 */
class TeacherControllerTest extends WebTestCase
{
    /**
     * test on createTeacher
     * @return [type] [description]
     */
    public function testCreateTeacher()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/teachers/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/teachers");

        $crawler = $client->click($crawler->selectLink('Ajouter')->link());

        $form = $crawler->selectButton('Créer')->form(array(
            'lastname'  => 'Foo',
            'firstname'  => 'Bar',
        ));

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('html:contains("L\'enseignant(e)")')->count(), 'Missing element html:contains("L\'enseignant(e) / intervenant(e) a bien été créé(e)")');
    }

}
