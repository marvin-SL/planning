<?php
/**
* MailingControllerTest Doc Comment.
*
* PHP version 5.5.9
*
* @author Sainte-Luce Marvin <marvin.sainteluce@gmail.com>
*
* @link   https://github.com/marvin-SL/planning
*/
namespace AppBundle\Tests\Controller\Admin;

use AppBundle\Tests\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 *  test on Mailing.
 */
class MailingControllerTest extends WebTestCase
{
    /**
     * test on index.
     */
    public function testIndex()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/mailing/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/classrooms');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("liste de diffusion G1")')->count(), 'Missing element html:contains("liste de diffusion G1")');
    }

    /**
     * test on createMailing.
     */
    public function testNewMailing()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/mailing/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/mailing/');

        $crawler = $client->click($crawler->selectLink('Ajouter')->link());

        $form = $crawler->selectButton('Créer')->form(array(
            'app_mailing[name]' => 'mailing-test',
            'app_mailing[mails]' => "aa@aa.fr;bb@bb.fr;cc@cc.fr"
        ));

        $client->submit($form);

        $crawler = $client->followRedirect();
    }

    // /**
    //  * test on fail Mailing edition.
    //  */
    // public function testfailMailingEdit()
    // {
    //     $client = static::createClient();
    //
    //     $this->login($client, 'marvin.sainteluce', 'cmw');
    //
    //     $crawler = $client->request('GET', '/admin/mailing/blablabla123/edit');
    //
    //     $this->setExpectedException('NotFoundHttpException', "Unable to find mailing list with slug 'blablabla123'");
    //
    // }
    //

        /**
         * test on edit Mailing.
         */
        public function testEditMailing()
        {
            $client = static::createClient();

            $this->login($client, 'marvin.sainteluce', 'cmw');

            $crawler = $client->request('GET', '/admin/mailing/');

            $link = $crawler->filter('a:contains("Editer")')->eq(0)->link();

            $crawler = $client->click($link);

            $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/mailing/liste-de-diffusion-g1/edit');

            $form = $crawler->selectButton('app_mailing[save]')->form();

            $form['app_mailing[name]'] = 'test-edit';


            $form['app_mailing[mails]'] = 'dd@dd.fr;ee@ee.fr;marvin.ipsos@gmail.com';

            $this->assertTrue($client->getResponse()->isSuccessful(), 'mails edited');

            $client->submit($form);

            $client->followRedirects();

            $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/mailing/');

            $crawler = $client->request('GET', '/admin/mailing/');

            $this->assertGreaterThan(0, $crawler->filter('html:contains("test-edit")')->count(), 'Found element html:contains("test-edit")');
        }

        /**
         * test on delete Mailing.
         */
        public function testDeleteMailing()
        {
            $client = static::createClient();

            $this->login($client, 'marvin.sainteluce', 'cmw');

            $crawler = $client->request('GET', '/admin/mailing/');

            $link = $crawler->filter('a:contains("Editer")')->eq(0)->link();

            $crawler = $client->click($link);

            $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/classrooms/test-edit/edit');

            $client->submit($crawler->selectButton('form[submit]')->form());

            $client->followRedirects();

            $this->assertTrue($client->getResponse()->isRedirect(), 'Redirected to /admin/mailing/');

            $crawler = $client->request('GET', '/admin/mailing/');

            $this->assertEquals(0, $crawler->filter('html:contains("test-edit")')->count(), 'Found element html:contains("test-edit")');
        }


        /**
         * test on Write action
         */
        public function testWriteMail()
        {
            $client = static::createClient();

            $this->login($client, 'marvin.sainteluce', 'cmw');

            $crawler = $client->request('GET', '/admin/mailing/liste-de-diffusion-g2/write-email');

            $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/mailing/liste-de-diffusion-g2/write-email');

            $form = $crawler->selectButton('submitButton')->form();

            $form['object'] = "Foobar objet";

            $form['comment'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec augue quam, consequa";

            $client->submit($form);
            $client->followRedirects();

            $crawler = $client->request('GET', '/admin/dashboard');
file_put_contents('dump.html', $client->getResponse());
            $this->assertGreaterThan(0, $crawler->filter('html:contains("Notification envoyée")')->count(), 'Not found element html:contains("Notification envoyée")');

        }

}
