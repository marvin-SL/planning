<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Event;


class LoadEventData extends AbstractFixture implements OrderedFixtureInterface
{
  /**
  * {@inheritDoc}
  */
  public function load(ObjectManager $manager)
  {
    $event1 = new Event();
    $event2 = new Event();
    $event3 = new Event();
    $event4 = new Event();

    $event1->setTitle('anglais');
    $event1->setStart(new \DateTime("2015-10-28 16:15:30"));
    $event1->setEnd(new \DateTime("2015-10-28 13:15:30"));
    $event1->setCalendar($this->getReference('calendar1'));

    $event2->setTitle('php');
    $event2->setStart(new \DateTime("2015-10-29 09:15:30"));
    $event2->setEnd(new \DateTime("2015-10-29 12:15:30"));
    $event2->setCalendar($this->getReference('calendar1'));

    $event3->setTitle('web doc');
    $event3->setStart(new \DateTime("2015-10-30 09:15:30"));
    $event3->setEnd(new \DateTime("2015-10-30 12:15:30"));
    $event3->setCalendar($this->getReference('calendar2'));

    $event4->setTitle('ux');
    $event4->setStart(new \DateTime("2015-10-31 09:15:30"));
    $event4->setEnd(new \DateTime("2015-10-31 12:15:30"));
    $event4->setCalendar($this->getReference('calendar3'));

    $manager->persist($event1);
    $manager->persist($event2);
    $manager->persist($event3);
    $manager->persist($event4);
    
    $manager->flush();
  }

  /**
    * {@inheritDoc}
    */
   public function getOrder()
   {
       return 2; // the order in which fixtures will be loaded
   }

}
