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
//namespace AppBundle\Tests\Controller;

// use AppBundle\Tests\WebTestCase;
//
// /**
//  *  test on Classroom.
//  */
// class ClassroomControllerTest extends WebTestCase
// {
//     /**
//      * test on index.
//      */
//     public function testIndex()
//     {
//         $client = static::createClient();
//
//         $this->login($client, 'marvin.sainteluce', 'cmw');
//
//         $crawler = $client->request('GET', '/admin/classrooms/');
//
//         $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/classrooms');
//
//         $this->assertGreaterThan(0, $crawler->filter('html:contains("Copernic")')->count(), 'Missing element html:contains("Copernic")');
//     }
//
//     /**
//      * test on createClassroom.
//      */
//     public function testNewClassroom()
//     {
//         $client = static::createClient();
//
//         $this->login($client, 'marvin.sainteluce', 'cmw');
//
//         $crawler = $client->request('GET', '/admin/classrooms/');
//
//         $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/classrooms/');
//
//         $crawler = $client->click($crawler->selectLink('Ajouter')->link());
//
//         $form = $crawler->selectButton('Créer')->form(array(
//             'app_classroom[name]' => 'foo',
//         ));
//
//         $client->submit($form);
//
//         $crawler = $client->followRedirect();
//     }
//
//     /**
//      * test on edit Classroom.
//      */
//     public function testEditClassroom()
//     {
//         $client = static::createClient();
//
//         $this->login($client, 'marvin.sainteluce', 'cmw');
//
//         $crawler = $client->request('GET', '/admin/classrooms/');
//
//         $link = $crawler->filter('a:contains("Editer")')->eq(0)->link();
//
//         $crawler = $client->click($link);
//
//         $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/classrooms/1/edit');
//
//         $form = $crawler->selectButton('app_classroom[save]')->form();
//
//         $form['app_classroom[name]'] = 'test-edit';
//
//         $this->assertTrue($client->getResponse()->isSuccessful(), 'name edited');
//
//         $client->submit($form);
//
//         $client->followRedirects();
//
//         $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/classrooms/');
//
//         $crawler = $client->request('GET', '/admin/classrooms/');
//
//         $this->assertGreaterThan(0, $crawler->filter('html:contains("test-edit")')->count(), 'Found element html:contains("test-edit")');
//     }
//
//     /**
//      * test on delete Classroom.
//      */
//     public function testDeleteClassroom()
//     {
//         $client = static::createClient();
//
//         $this->login($client, 'marvin.sainteluce', 'cmw');
//
//         $crawler = $client->request('GET', '/admin/classrooms/');
//
//         $link = $crawler->filter('a:contains("Editer")')->eq(0)->link();
//
//         $crawler = $client->click($link);
//
//         $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/classrooms/1/edit');
//
//         $client->submit($crawler->selectButton('form[submit]')->form());
//
//         $client->followRedirects();
//
//         $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/classrooms/');
//
//         $crawler = $client->request('GET', '/admin/classrooms/');
//
//         $this->assertEquals(0, $crawler->filter('html:contains("Copernic")')->count(), 'Found element html:contains("Copernic")');
//     }
//s}
