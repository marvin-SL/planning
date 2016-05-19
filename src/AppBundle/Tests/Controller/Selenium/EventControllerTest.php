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
namespace AppBundle\Tests\Controller\Selenium;

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
        $this->setBrowserUrl('http://localhost/planning');
    }

    /**
    * login action
    */
    protected function login()
    {
        $this->prepareSession()->currentWindow()->maximize();
        $this->url('http://localhost/planning/login');
        sleep(3);
        $form = $this->byId('login-form');
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
        $this->url('http://localhost/planning/admin/calendars/planning-test-test-edit/edit');
        sleep(5);
        $this->clickOnElement('addButton');
        sleep(5);
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
            'element' => $this->byId('app_subject_calendar'),
        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byXPath('/html/body/div[1]/div/div/div[2]/div[2]/div/form/div[3]/select/option[2]'),

        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byId("app_subject_subject"),

        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byXPath('/html/body/div[1]/div/div/div[2]/div[2]/div/form/div[4]/select/option[2]')
        ));

        $this->buttondown();
        $this->buttonup();

        $this->moveto(array(
            'element' => $this->byId("app_subject_classroom"),

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

    }

    /**
     * test on edit Event.
     */
    public function testEditEvent()
    {
        $this->login();
        $this->url('http://localhost/planning/admin/calendars/planning-test-test-edit/edit');
        sleep(3);
        $this->byXPath("/html/body/div[1]/div/div/div[4]/div[2]/div/table/tbody/tr[1]/td[5]/a")->click();
        sleep(3);

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

    /**
     * test on delete Event.
     */
    public function testDeleteEvent()
    {
        $this->login();
        $this->url('http://localhost/planning/admin/calendars/planning-test-test-edit/edit');
        sleep(2);
        $this->byXpath("/html/body/div[2]/div[3]/a")->click();
        sleep(2);
        $this->byXPath("/html/body/div[1]/div/div/div[4]/div[2]/div/table/tbody/tr[1]/td[5]/a")->click();
        sleep(2);
        $this->clickOnElement('deleteButton');
        sleep(2);

        $this->moveto(array(
            'element' => $this->byId('form_submit'),
        ));

        $this->buttondown();
        $this->buttonup();

        $message = $this->byXpath('/html/body/div[1]/div/div/div[1]');

        $this->assertRegExp('/bien été supprimé/i', $message->text());
    }
}
