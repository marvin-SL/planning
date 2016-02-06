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
 *  test on Dashboard.
 */
class DashboardControllerTest extends WebTestCase
{
    /**
     * test on index.
     */
    public function testIndex()
    {
        $client = static::createClient();

        $this->login($client, 'marvin.sainteluce', 'cmw');

        $crawler = $client->request('GET', '/admin/dashboard/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/dashboard');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Bienvenue marvin")')->count(), 'Missing element html:contains("Bienvenue marvin")');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'Unexpected HTTP status code for GET /admin/dashboard');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("groupe 1")')->count(), 'Missing element html:contains("groupe 1")');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Anglais")')->count(), 'Missing element html:contains("Anglais")');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Julian Trudy")')->count(), 'Missing element html:contains("Julian Trudy")');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("C343, Copernic (en face des machines)")')->count(), 'Missing element html:contains("C343, Copernic (en face des machines)")');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("marvin.sainteluce")')->count(), 'Missing element html:contains("marvin.sainteluce")');
    }

}
