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
namespace AppBundle\Tests\Controller;

// use AppBundle\Tests\WebTestCase;
//
// /**
//  *  test on User.
//  */
// class UserControllerTest extends WebTestCase
// {
//
//     /**
//      * test on index.
//      *
//      */
//     public function testIndex()
//     {
//
//         $client = static::createClient();
//
//         $this->login($client, 'marvin.sainteluce', 'cmw');
//
//         $crawler = $client->request('GET', '/admin/users/');
//
//         $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/users");
//
//         $this->assertGreaterThan(0, $crawler->filter('html:contains("marvin.sainteluce")')->count(), 'Missing element html:contains("marvin.sainteluce")');
//         $this->assertGreaterThan(0, $crawler->filter('html:contains("Super administrateur")')->count(), 'Missing element html:contains("Super administrateur")');
//     }
//
//     /**
//      * test on createUser.
//      *
//      */
//     public function testNewUser()
//     {
//         $client = static::createClient();
//
//         $this->login($client, 'marvin.sainteluce', 'cmw');
//
//         $crawler = $client->request('GET', '/admin/users/');
//
//         $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/users/");
//
//         $crawler = $client->click($crawler->selectLink('Ajouter')->link());
//
//         $form = $crawler->selectButton('Créer')->form(array(
//             'appbundle_user[email]' => 'aa@aa.fr',
//             'appbundle_user[lastname]' => 'foo',
//             'appbundle_user[firstname]' => 'bar',
//             'appbundle_user[roles]' => 'ROLE_USER',
//         ));
//
//         $client->submit($form);
//
//         $client->followRedirects();
//
//         $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/users/');
//
//         $crawler = $client->request('GET', '/admin/users/');
//
//         $this->assertGreaterThan(0, $crawler->filter('html:contains("bar.foo")')->count(), 'Missing element html:contains("bar.foo")');
//
//     }
//
//     // /**
//     //  * test on edit User.
//     //  *
//     //  */
//     // public function testEditUser()
//     // {
//     //     $client = static::createClient();
//     //
//     //     $this->login($client, 'marvin.sainteluce', 'cmw');
//     //
//     //     $crawler = $client->request('GET', '/admin/users/1/edit');
//     //
//     //     $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/users/1/edit");
//     //
//     //     $form = $crawler->selectButton('save')->form(array(
//     //         'name' => 'user-edited',
//     //         'teachers' => '1',
//     //         'color' => '#00ffff'
//     //     ));
//     //
//     //     $client->submit($form);
//     //
//     //     $crawler = $client->followRedirect();
//     // }
//
//     // /**
//     //  * test on delete User
//     //  *
//     //  */
//     // public function testDeleteUser()
//     // {
//     //     $client = static::createClient();
//     //
//     //     $this->login($client, 'marvin.sainteluce', 'cmw');
//     //
//     //     $crawler = $client->request('GET', '/admin/users/1/edit');
//     //
//     //     $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /admin/users/1/edit");
//     //
//     //     $client->submit($crawler->selectButton('form_submit')->form());
//     //
//     //     $crawler = $client->followRedirect();
//     //
//     // }
//}
