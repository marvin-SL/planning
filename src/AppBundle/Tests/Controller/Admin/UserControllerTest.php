<?php
/**
* UserControllerTest Doc Comment.
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
 *  test on User.
 */
class UserControllerTest extends WebTestCase
{

    /**
     * test on index.
     *
     */
    public function testIndex()
    {

        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/users/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/users");

        $this->assertGreaterThan(0, $crawler->filter('html:contains("marvin.sainteluce")')->count(), 'Missing element html:contains("marvin.sainteluce")');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Black Ninja")')->count(), 'Missing element html:contains("Super administrateur")');
    }

    /**
     * test on createUser.
     *
     */
    public function testNewUser()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/users/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/users/");

        $crawler = $client->click($crawler->selectLink('Ajouter')->link());

        $form = $crawler->selectButton('Créer')->form(array(
            'appbundle_user[email]' => 'aa@aa.fr',
            'appbundle_user[lastname]' => 'foo',
            'appbundle_user[firstname]' => 'bar',
            'appbundle_user[roles]' => 'ROLE_EDITOR',
        ));

        $client->submit($form);

        $client->followRedirects();

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/users/');

        $crawler = $client->request('GET', '/admin/users/');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("bar.foo")')->count(), 'Missing element html:contains("bar.foo")');

    }

    /**
     * test on createUser logged as Admin role.
     *
     */
    public function testNewUserAsAdmin()
    {
        $client = static::createClient();

        $this->login($client, 'laure.robillard', 'cmw');

        $crawler = $client->request('GET', '/admin/users/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/users/");

        $crawler = $client->click($crawler->selectLink('Ajouter')->link());

        $form = $crawler->selectButton('Créer')->form(array(
            'appbundle_user[email]' => 'bb@bb.fr',
            'appbundle_user[lastname]' => 'bar',
            'appbundle_user[firstname]' => 'foo',
            'appbundle_user[roles]' => 'ROLE_ADMIN',
        ));

        $client->submit($form);

        $client->followRedirects();

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/users/');

        $crawler = $client->request('GET', '/admin/users/');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("bar.foo")')->count(), 'Missing element html:contains("bar.foo")');

    }

    /**
     * test on edit User.
     *
     */
    public function testEditUser()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/users/3/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/users/3/edit");

        $form = $crawler->selectButton('appbundle_user[save]')->form(array(
            'appbundle_user[email]' => 'sam.winchester@cmw.com',
            'appbundle_user[lastname]' => 'winchester',
            'appbundle_user[firstname]' => 'samuel',
            'appbundle_user[roles]' => 'ROLE_ADMIN'
        ));

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/users/');

        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('html:contains("samuel")')->count(), 'Missing element html:contains("samuel")');
    }

    /**
     * test on delete User
     *
     */
    public function testDeleteUser()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/users/3/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/users/3/edit");

        $client->submit($crawler->selectButton('form[submit]')->form());

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/user/');

        $client->followRedirects();

        $crawler = $client->request('GET', '/admin/users/');

        $this->assertEquals(0, $crawler->filter('html:contains("dean.winchester")')->count(), 'Found element html:contains("dean.winchester")');

    }
}
