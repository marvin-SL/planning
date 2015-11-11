<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Calendar;


class LoadCalendarData extends AbstractFixture implements OrderedFixtureInterface
{
  /**
  * {@inheritDoc}
  */
  public function load(ObjectManager $manager)
  {
    $calendar1 = new Calendar();
    $calendar2 =  new Calendar();
    $calendar3 =  new Calendar();

    $calendar1->setTitle('groupe 1');
    $calendar2->setTitle('groupe 2');
    $calendar3->setTitle('groupe 3');

    $this->addReference('calendar1', $calendar1);
    $this->addReference('calendar2', $calendar2);
    $this->addReference('calendar3', $calendar3);

    $manager->flush();

  }

  /**
    * {@inheritDoc}
    */
   public function getOrder()
   {
       return 3; // the order in which fixtures will be loaded
   }
}
