<?php
/**
* ClassroomControllerTest Doc Comment
*
* PHP version 5.5.9
*
* @author Sainte-Luce Marvin <marvin.sainteluce@gmail.com>
* @link   https://github.com/marvin-SL/planning
*
*/
namespace AppBundle\Tests\Controller;

use AppBundle\Tests\WebTestCase;

/**
 *  test on Classroom
 */
class ClassroomControllerTest extends WebTestCase
{
    /**
     * test on index
     * @return [type] [description]
     */
    public function testIndex()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/classrooms/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/classrooms");

        $this->assertGreaterThan(0, $crawler->filter('html:contains("C343, Copernic")')->count(), 'Missing element html:contains("C343, Copernic")');
    }

    /**
     * test on createClassroom
     * @return [type] [description]
     */
    public function testNewClassroom()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/classrooms/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/classrooms");

        $crawler = $client->click($crawler->selectLink('Ajouter')->link());

        $form = $crawler->selectButton('Créer')->form(array(
            'name'  => 'Foo'
        ));

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Foo")')->count(), 'Missing element html:contains("Foo")');
    }

    /**
     * test on edit Classroom
     * @return [type] [description]
     */
    public function testEditClassroom()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/classrooms/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/classrooms");

        $link = $crawler
        ->filter('a:contains("Editer")')
        ->eq(0)
        ->link()
        ;

        $crawler = $client->click($crawler->selectLink('Ajouter')->link());

        $form = $crawler->selectButton('Créer')->form(array(
            'name'  => 'FooBar'
        ));

        $client->submit($form);

        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Foo")')->count(), 'Missing element html:contains("Foo")');
    }
}
