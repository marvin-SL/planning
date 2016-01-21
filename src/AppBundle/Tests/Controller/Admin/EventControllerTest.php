<?php
/**
* EventControllerTest Doc Comment.
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
 *  test on Event.
 */
class EventControllerTest extends PHPUnit_Extensions_Selenium2TestCase
{
    /**
    * setup
    */
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost/planning/');
    }

    /**
    * login action
    */
    protected function login()
    {
        $this->url('http://localhost/planning/login');
        $this->waitForPageToLoad("30000");
        $form = $this->byCssSelector('form');
        $action = $form->attribute('action');
        $this->byName('_username')->value('marvin.sainteluce');
        $this->byName('_password')->value('cmw');
        $form->submit();
    }


    /**
     * test on createEvent.
     */
    public function testNewEvent()
    {
        $this->login();
        $this->url('http://localhost/planning/admin/calendars/groupe-1/edit');
        $this->clickOnElement('addButton');

        $this->moveto(array(
            'element' => $this->byId('app_subject_startDate'),
        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byXPath('/html/body/div[3]/div[3]/table/tfoot/tr/th'),

        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byId('app_subject_endDate'),
        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byXPath('/html/body/div[4]/div[3]/table/tfoot/tr/th'),

        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byId("app_subject_subject"),

        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byXPath('/html/body/div[1]/div/div/div[2]/div[2]/div/form/div[5]/select/option[2]')
        ));

        $this->buttondown();
        $this->buttonup();

        $this->byId('app_subject_notice')->value('une info complémentaire');

        $this->byId('app_subject_save')->click();

        $message = $this->byXpath('//*[@id="flashes"]');

        $this->assertRegExp('/bien été créé/i', $message->text());


        // $form = $this->byCssSelector('form');
        // $action = $form->attribute('action');
        // $this->byId('startDate')->value('foo');
        // $form->submit();
        // $message = $this->byXpath('//*[@id="flashes"]');
        // $this->assertRegExp('/bien été créée/i', $message->text());
    }

    /**
     * test on edit Event.
     */
    public function testEditEvent()
    {
        $this->login();
        $this->url('http://localhost/planning/admin/calendars/groupe-1/edit');
        $this->byXPath("/html/body/div[1]/div/div/div[4]/div[2]/div/table/tbody/tr[1]/td[5]/a")->click();

        $this->moveto(array(
            'element' => $this->byId('app_subject_startDate'),
        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byXPath('/html/body/div[3]/div[3]/table/tfoot/tr/th'),

        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byId('app_subject_endDate'),
        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byXPath('/html/body/div[4]/div[3]/table/tfoot/tr/th'),

        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byId("app_subject_subject"),

        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byXPath('/html/body/div[1]/div/div/div[2]/div[2]/div/form/div[5]/select/option[2]')
        ));

        $this->buttondown();
        $this->buttonup();

        $this->byId('app_subject_notice')->value('une info complémentaire mise à jour');

        $this->byId('app_subject_save')->click();

        $message = $this->byXpath('//*[@id="flashes"]');

        $this->assertRegExp('/bien été mis à jour/i', $message->text());

    }
    //
    // /**
    //  * test on delete Event.
    //  */
    // public function testDeleteEvent()
    // {
    //     $client = static::createClient();
    //
    //     $this->login($client, 'marvin.sainteluce', 'cmw');
    //
    //     $crawler = $client->request('GET', '/admin/events/');
    //
    //     $link = $crawler->filter('a:contains("Editer")')->eq(0)->link();
    //
    //     $crawler = $client->click($link);
    //
    //     $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/events/1/edit');
    //
    //     $client->submit($crawler->selectButton('form[submit]')->form());
    //
    //     $client->followRedirects();
    //
    //     $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/events/');
    //
    //     $crawler = $client->request('GET', '/admin/events/');
    //
    //     $this->assertEquals(0, $crawler->filter('html:contains("Copernic")')->count(), 'Found element html:contains("Copernic")');
    // }
}
