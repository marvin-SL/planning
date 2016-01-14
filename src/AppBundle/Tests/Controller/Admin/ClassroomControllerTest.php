<?php
/**
* ClassroomControllerTest Doc Comment.
*
* PHP version 5.5.9
*
* @author Sainte-Luce Marvin <marvin.sainteluce@gmail.com>
*
* @link   https://github.com/marvin-SL/planning
*/
namespace AppBundle\Tests\Controller;

use PHPUnit_Extensions_Selenium2TestCase;
use AppBundle\Tests\WebTestCase;

/**
 *  test on Classroom.
 */
class ClassroomControllerTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowserUrl('http://localhost/planning/');
    }

    protected function login()
    {
        $this->url('http://localhost/planning/login');
        $form = $this->byCssSelector('form');
        $action = $form->attribute('action');
        $this->byName('_username')->value('marvin.sainteluce');
        $this->byName('_password')->value('cmw');
        $form->submit();

    }

    // /**
    //  * test on index.
    //  *
    //  * @return [type] [description]
    //  */
    // public function testIndex()
    // {
    //     $client = static::createClient();
    //
    //     $this->login($client, 'marvin.sainteluce', 'cmw');
    //
    //     $crawler = $client->request('GET', '/admin/classrooms/');
    //
    //     $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/classrooms');
    //
    //     $this->assertGreaterThan(0, $crawler->filter('html:contains("C343, Copernic")')->count(), 'Missing element html:contains("C343, Copernic")');
    // }
    //
    // /**
    //  * test on createClassroom.
    //  *
    //  * @return [type] [description]
    //  */
    // public function testNewClassroom()
    // {
    //     $client = static::createClient();
    //
    //     $this->login($client, 'marvin.sainteluce', 'cmw');
    //
    //     $crawler = $client->request('GET', '/admin/classrooms/');
    //
    //     $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/classrooms');
    //
    //     $crawler = $client->click($crawler->selectLink('Ajouter')->link());
    //
    //     $form = $crawler->selectButton('Créer')->form(array(
    //         'name' => 'Foo',
    //     ));
    //
    //     $client->submit($form);
    //
    //     $crawler = $client->followRedirect();
    //
    //     $this->assertGreaterThan(0, $crawler->filter('html:contains("Foo")')->count(), 'Missing element html:contains("Foo")');
    // }

    /**
     * test on edit Classroom.
     *
     * @return [type] [description]
     */
    public function testEditClassroom()
    {
        //$client = static::createClient();

        $this->login();

        //$crawler = $client->request('GET', 'admin/classrooms/1/edit');
        $this->url('http://localhost/planning/admin/classrooms/1/edit');

        // $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET admin/classrooms/1/edit');

        $this->clickOnElement('deleteButton');
        $this->timeouts()->implicitWait(50000);
        $this->clickOnElement('form_submit');
        $message = $this->byXpath('//*[@id="flashes"]');
        $this->assertRegExp("/bien été/i", $message->text());
        // $form = $crawler->selectButton('Mettre à jour')->form(array(
        //     'name' => 'Test', ));

        // $client->submit($form);
        // $crawler = $client->followRedirect();

        // $this->assertGreaterThan(0, $crawler->filter('html:contains("Foo")')->count(), 'Missing element html:contains("Foo")');
    }

    public function testDeleteClassroom()
    {
        $this->login();
        $this->url('http://localhost/planning/admin/classrooms/1/edit');
        $this->clickOnElement('deleteButton');
        $this->clickOnElement('form_submit');
        $message = $this->byXpath('//*[@id="flashes"]');
        $this->assertRegExp("/bien été/i", $message->text());
    }
}
