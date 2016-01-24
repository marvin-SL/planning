<?php
/**
* SubjectControllerTest Doc Comment.
*
* PHP version 5.5.9
*
* @author Sainte-Luce Marvin <marvin.sainteluce@gmail.com>
*
* @link   https://github.com/marvin-SL/planning
*/
namespace AppBundle\Tests\Controller\Admin;

use AppBundle\Tests\WebTestCase;

/**
 *  test on Subject.
 */
class SubjectControllerTest extends WebTestCase
{

    /**
     * test on index.
     *
     */
    public function testIndex()
    {

        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/subjects/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/subjects");

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Anglais")')->count(), 'Missing element html:contains("Anglais")');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Julian, Trudy")')->count(), 'Missing element html:contains("Julian, Trudy")');
    }

    /**
     * test on createSubject.
     *
     */
    public function testNewSubject()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/subjects/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/subjects/");

        $crawler = $client->click($crawler->selectLink('Ajouter')->link());

        $form = $crawler->selectButton('Créer')->form(array(
            'app_subject[name]' => 'subject',
            'app_subject[teachers]' => '3',
            'app_subject[color]' => '#e69138'
        ));

        $client->submit($form);

        $crawler = $client->followRedirect();

    }

    /**
     * test on edit Subject.
     *
     */
    public function testEditSubject()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/subjects/');

        $link = $crawler->filter('a:contains("Editer")')->eq(0)->link();

        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/subjects/1/edit");

        $form = $crawler->selectButton('app_subject[save]')->form(array(
            'app_subject[name]' => 'subject-edited',
            'app_subject[teachers]' => '1',
            'app_subject[color]' => '#00ffff'
        ));

        $client->submit($form);

        $client->followRedirects();

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/subjects/');

        $crawler = $client->request('GET', '/admin/subjects/');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("subject-edited")')->count(), 'Found element html:contains("subject-edited")');

    }

    /**
     * test on delete Subject
     *
     */
    public function testDeleteSubject()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/subjects/');

        $link = $crawler->filter('a:contains("Editer")')->eq(0)->link();

        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/subjects/1/edit");

        $client->submit($crawler->selectButton('form[submit]')->form());

        $client->followRedirects();

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/subjects/');

        $this->assertEquals(0, $crawler->filter('html:contains("Anglais")')->count(), 'Found element html:contains("Anglais")');
        $this->assertEquals(0, $crawler->filter('html:contains("Julian, Trudy")')->count(), 'Found element html:contains("Julian, Trudy")');


    }
}
