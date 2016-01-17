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

    /**
     * test on index.
     *
     * @return [type] [description]
     */
    public function testIndex()
    {
        $this->login();
        $this->url('http://localhost/planning/admin/classrooms/');
        $message = $this->byXpath('/html/body/div[1]/div/div/div[4]/div/table/tbody/tr[1]/td[1]');
        $this->assertRegExp('/C343, Copernic/i', $message->text());

        $crawler = $client->request('GET', '/admin/classrooms/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/classrooms');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("C343, Copernic")')->count(), 'Missing element html:contains("C343, Copernic")');
    }

    /**
     * test on createClassroom.
     *
     * @return [type] [description]
     */
    public function testNewClassroom()
    {
        $this->login();
        $this->url('http://localhost/planning/admin/classrooms/');
        $this->clickOnElement('Ajouter');

        $form = $this->byCssSelector('form');
        $action = $form->attribute('action');
        $this->byId('name')->value('foo');
        $form->submit();
        $message = $this->byXpath('//*[@id="flashes"]');
        $this->assertRegExp('/bien été créée/i', $message->text());

    }

    /**
     * test on edit Classroom.
     *
     * @return [type] [description]
     */
    public function testEditClassroom()
    {
        $this->login();
        $this->url('http://localhost/planning/admin/classrooms/1/edit');

        $form = $this->byCssSelector('form');
        $action = $form->attribute('action');
        $this->byId('name')->value('foo-edited');
        $this->timeouts()->implicitWait(50000);
        $form->submit();
        $message = $this->byXpath('//*[@id="flashes"]');
        $this->assertRegExp('/bien été mise à jour/i', $message->text());

    }

    public function testDeleteClassroom()
    {
        $this->login();
        $this->url('http://localhost/planning/admin/classrooms/1/edit');
        $this->clickOnElement('deleteButton');
        $this->clickOnElement('form_submit');
        $message = $this->byXpath('//*[@id="flashes"]');
        $this->assertRegExp('/bien été/i', $message->text());
    }

    protected function loginCustom(Client $client, $username, $password)
    {
        $crawler = $client->request('GET', '/login');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The login page is successful');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Connexion")')->count());

        $form = $crawler->selectButton('Connexion')->form();

        $crawler = $client->submit($form, array('_username' => $username, '_password' => $password));
    }
}
