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
namespace AppBundle\Tests\Controller\Admin;

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
            'app_teacher[lastname]' => 'Foo',
            'app_teacher[firstname]' => 'Bar',
        ));

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('html:contains("L\'enseignant(e)")')->count(), 'Missing element html:contains("L\'enseignant(e) / intervenant(e) a bien été créé(e)")');
    }

    /**
     * test on fail Teacher edition.
     */
    public function failTeacherEdit()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/teachers/999/edit');

        $this->setExpectedException('NotFoundHttpException', "Unable to find teacher with id '999'");

        throw new NotFoundHttpException("Unable to find classroom with id '999'", 10);
    }

    public function testEditTeacher()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/teachers/');

        $link = $crawler->filter('a:contains("Editer")')->eq(0)->link();

        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/teachers/1/edit');

        $form = $crawler->selectButton('Mettre à jour')->form();
        $form['app_teacher[lastname]'] = 'Foo-edited';
        $form['app_teacher[firstname]'] = 'Bar-edited';

        $client->submit($form);

        $client->followRedirects();

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/teachers/');

        $crawler = $client->request('GET', '/admin/teachers/');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Foo-edited")')->count(), 'Found element html:contains("Foo-edited")');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Bar-edited")')->count(), 'Found element html:contains("Bar-edited")');
    }

    /**
     * test on delete Teacher.
     */
    public function testDeleteTeacher()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/teachers/');

        $link = $crawler->filter('a:contains("Editer")')->eq(0)->link();

        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/teachers/1/edit');

        $client->submit($crawler->selectButton('form[submit]')->form());

        $client->followRedirects();

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/subjects/');

        $this->assertEquals(0, $crawler->filter('html:contains("Julian, Trudy")')->count(), 'Found element html:contains("Julian")');


    }
}
