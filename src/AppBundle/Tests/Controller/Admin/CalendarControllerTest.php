<?php
/**
* CalendarControllerTest Doc Comment.
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
 *  test on Calendar.
 */
class CalendarControllerTest extends WebTestCase
{
    /**
     * test on index.
     */
    public function testIndex()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/calendars/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/calendars');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("groupe 1")')->count(), 'Missing element html:contains("groupe 1")');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("groupe-1")')->count(), 'Missing element html:contains("groupe-1")');
    }

     /**
      * test on failing to show calender.
      */
    public function failShow()
    {
         $client = static::createClient();

         $this->login($client, 'marvin.sainteluce', 'cmw');

         $crawler = $client->request('GET', '/admin/calendars/999/edit');

         $this->setExpectedException('NotFoundHttpException', "Unable to find calendar with slug '999'");

         throw new NotFoundHttpException("Unable to find calendar with slug '999'", 10);
    }

    /**
     * test on createCalendar.
     */
    public function testNewCalendar()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/calendars/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/calendars/');

        $crawler = $client->click($crawler->selectLink('Ajouter')->link());

        $form = $crawler->selectButton('Créer')->form(array(
            'app_calendar[title]' => '##!planning test\'##',
            ));

        $client->submit($form);

        $crawler = $client->followRedirect();
    }

    /**
     * test on fail Calendar edition.
     */
    public function failCalendarEdit()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/calendars/none-existant/edit');

        $this->setExpectedException('NotFoundHttpException', "Unable to find calendar with slug 'none-exitant'");

        throw new NotFoundHttpException("Unable to find calendar with slug 'none-exitant'", 10);
    }

    /**
     * test on edit Calendar.
     */
    public function testEditCalendar()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/calendars/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/calendars/1/edit');

        $link = $crawler
            ->filter('a:contains("Editer")') // find all links with the text "Greet"
            ->eq(0) // select the second link in the list
            ->link()
        ;

        $crawler = $client->click($link);

        $form = $crawler->selectButton('app_calendar[save]')->form();

        $form['app_calendar[title]'] = '##!planning test\'##test-edit';

        $this->assertTrue($client->getResponse()->isSuccessful(), 'name edited');

        $client->submit($form);

        $client->followRedirects();

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/calendars/');

        $crawler = $client->request('GET', '/admin/calendars/');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("##!planning test\'##test-edit")')->count(), 'Missing element html:contains("##!planning test\'##test-edit")');
    }

    /**
     * test on delete Calendar.
     */
    public function testDeleteCalendar()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/calendars/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/calendars/1/edit');

        $link = $crawler
                ->filter('a:contains("Editer")') // find all links with the text "Greet"
                ->eq(0) // select the second link in the list
                ->link()
            ;

        $crawler = $client->click($link);

        $client->submit($crawler->selectButton('form[submit]')->form());

        $client->followRedirects();

        $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/calendars/');

        $crawler = $client->request('GET', '/admin/calendars/');

        $this->assertEquals(0, $crawler->filter('html:contains("##!planning test\'##test-edit")')->count(), 'Found element html:contains("##!planning test\'##test-edit")');
    }
}
