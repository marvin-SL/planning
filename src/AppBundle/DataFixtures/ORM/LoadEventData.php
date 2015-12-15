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

    $event1->setStartDate(new \DateTime("2015-10-28 16:15:30"));
    $event1->setEndDate(new \DateTime("2015-10-28 13:15:30"));
    $event1->setCalendar($this->getReference('calendar1'));
    $event1->setSubject($this->getReference('subject1'));
    $event1->setClassRoom($this->getReference('classRoom1'));
    $event1->setNotice('');

    $event2->setStartDate(new \DateTime("2015-10-29 09:15:30"));
    $event2->setEndDate(new \DateTime("2015-10-29 12:15:30"));
    $event2->setCalendar($this->getReference('calendar1'));
    $event2->setSubject($this->getReference('subject2'));
    $event2->setClassRoom($this->getReference('classRoom2'));
    $event2->setNotice('');

    $event3->setStartDate(new \DateTime("2015-10-30 09:15:30"));
    $event3->setEndDate(new \DateTime("2015-10-30 12:15:30"));
    $event3->setCalendar($this->getReference('calendar2'));
    $event3->setSubject($this->getReference('subject3'));
    $event3->setClassRoom($this->getReference('classRoom1'));
    $event3->setNotice('Bonzon');

    $event4->setStartDate(new \DateTime("2015-10-31 09:15:30"));
    $event4->setEndDate(new \DateTime("2015-10-31 12:15:30"));
    $event4->setCalendar($this->getReference('calendar3'));
    $event4->setSubject($this->getReference('subject1'));
    $event4->setClassRoom($this->getReference('classRoom3'));
    $event4->setNotice('En association avec le master Numi');

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
       return 5; // the order in which fixtures will be loaded
   }

}
