<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Event;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadEventData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
    * @var ContainerInterface
    */
   private $container;

   public function setContainer(ContainerInterface $container = null)
   {
       $this->container = $container;
   }
    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        $event1 = new Event();
        $event2 = new Event();
        $event3 = new Event();
        $event4 = new Event();

        $serializer  = $this->container->get('app.serializer');

        $event1->setStartDate(new \DateTime("now"));
        $event1->setEndDate(new \DateTime("+3 hours"));
        $event1->setCalendar($this->getReference('calendar1'));
        $event1->setSubject($this->getReference('subject1'));
        $event1->setClassroom($this->getReference('classroom1'));
        $event1->setNotice('');

        $event2->setStartDate(new \DateTime("+24 hours"));
        $event2->setEndDate(new \DateTime("+27 hours"));
        $event2->setCalendar($this->getReference('calendar1'));
        $event2->setSubject($this->getReference('subject2'));
        $event2->setClassroom($this->getReference('classroom2'));
        $event2->setNotice('');

        $event3->setStartDate(new \DateTime("+51 hours"));
        $event3->setEndDate(new \DateTime("+54 hours"));
        $event3->setCalendar($this->getReference('calendar2'));
        $event3->setSubject($this->getReference('subject3'));
        $event3->setClassroom($this->getReference('classroom1'));
        $event3->setNotice('Bonzon');

        $event4->setStartDate(new \DateTime("+78 hours"));
        $event4->setEndDate(new \DateTime("+81 hours"));
        $event4->setCalendar($this->getReference('calendar3'));
        $event4->setSubject($this->getReference('subject1'));
        $event4->setClassroom($this->getReference('classroom3'));
        $event4->setNotice('En association avec le master Numi');

        $manager->persist($event1);
        $manager->persist($event2);
        $manager->persist($event3);
        $manager->persist($event4);
        $manager->flush();

        $serializer->serializeToXmlAction($event1->getCalendar());
        $serializer->serializeToXmlAction($event2->getCalendar());
        $serializer->serializeToXmlAction($event3->getCalendar());
        $serializer->serializeToXmlAction($event4->getCalendar());
    }

    /**
    * {@inheritDoc}
    */
    public function getOrder()
    {
        return 5; // the order in which fixtures will be loaded
    }

}
