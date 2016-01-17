<?php
/**
* TeacherControllerTest Doc Comment.
*
* PHP version 5.5.9
*
* @author Sainte-Luce Marvin <marvin.sainteluce@gmail.com>
*
* @link   https://github.com/marvin-SL/planning
*/
namespace AppBundle\Tests\Controller;

use AppBundle\Tests\WebTestCase;

/**
 *  test on teacher.
 */
class TeacherControllerTest extends WebTestCase
{
    /**
     * test on index.
     *
     * @return [type] [description]
     */
    public function testIndex()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/teachers/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/teachers');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Julian")')->count(), 'Missing element html:contains("Julian")');
    }

    /**
     * test on createTeacher.
     *
     * @return [type] [description]
     */
    public function testNewTeacher()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/teachers/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/teachers');

        $crawler = $client->click($crawler->selectLink('Ajouter')->link());

        $form = $crawler->selectButton('Créer')->form(array(
            'lastname' => 'Foo',
            'firstname' => 'Bar',
        ));

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('html:contains("L\'enseignant(e)")')->count(), 'Missing element html:contains("L\'enseignant(e) / intervenant(e) a bien été créé(e)")');
    }

    public function testEditTeacher()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/teachers/1/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/teachers/1/edit');

        $form = $crawler->selectButton('Mettre à jour')->form();
        $form['lastname'] = 'Foo-edited';
        $form['firstname'] = 'Bar-edited';

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('html:contains("L\'enseignant(e) / intervenant(e)")')->count(), 'Missing element html:contains("L\'enseignant(e) / intervenant(e) ")');
    }

    /**
     * test on delete Teacher.
     */
    public function testDeleteTeacher()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/teachers/1/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/teachers/1/edit');

        $crawler = $client->click($crawler->selectLink('Supprimer')->link());
    }
}
