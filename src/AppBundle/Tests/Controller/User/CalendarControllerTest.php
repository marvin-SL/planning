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

namespace AppBundle\Tests\Controller\User;

use AppBundle\Tests\WebTestCase;

/**
 *  test on Calendar.
 */
class CalendarControllerTest extends WebTestCase
{
    public function testShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/calendar/groupe-3/show');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertGreaterThan(0, $crawler->filter('html:contains("groupe 3")')->count(), 'Missing element html:contains("groupe 3")');
    }

    public function testFailShow()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/calendar/azerty12121212/show');

        $this->assertTrue($client->getResponse()->isNotFound());
    }
}
