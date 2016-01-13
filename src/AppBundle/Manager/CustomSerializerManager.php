<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Manager\BaseManager;
use AppBundle\Entity\Event;
use AppBundle\Entity\Calendar;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *  CustomSerializer manager
 */
class CustomSerializerManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function serialize(Calendar $calendar)
    {
        $subjectRepository = $this->em->getRepository('AppBundle:Subject');
        $subjects = $subjectRepository->findAll();

        $eventRepository = $this->em->getRepository('AppBundle:Event');

        $tabTeachers = [];

        for($i = 0; $i < sizeof($subjects); $i++){
            $tabTeachers[]=$subjects[$i]->getName();
            foreach ($subjects[$i]->getTeachers() as $teacher)
            {

                for($y = 0; $y < sizeof($subjects[$i]); $y++)
                {

                    $tabTeachers[$subjects[$i]->getName()][] = $teacher->getLastname();

                }
            }
        }

        $query =  $this->em->getRepository('AppBundle:Event')->findCalendarEvents($calendar);

		$rootNode = new \SimpleXMLElement( "<data></data>" );

		foreach($query as $eventList){

            $eventNode = $rootNode->addChild('event');
            $eventNode->addChild("id", $eventList->getId());
            $eventNode->addChild("calendar", $eventList->getCalendar()->getTitle());
            $eventNode->addChild("start_date", $eventList->getStartDate()->format('Y-m-d H:i:s'));
            $eventNode->addChild("end_date", $eventList->getEndDate()->format('Y-m-d H:i:s'));
            $eventNode->addChild("classroom", $eventList->getClassroom()->getName());
            $eventNode->addChild("notice", $eventList->getNotice());
            $eventNode->addChild("subject", $eventList->getSubject()->getName()." / ".implode(",", $tabTeachers[$eventList->getSubject()->getName()]));
            $eventNode->addChild("color", $eventList->getSubject()->getColor());
        }

        $eventRepository = $this->em->getRepository('AppBundle:Event');

        $eventList = $eventRepository->findAll();

        if (!file_exists($this->container->get('kernel')->getRootDir() . '/../web/data/')) {

            mkdir($this->container->get('kernel')->getRootDir() . '/../web/data/', 0777, true);
            $path = $this->container->get('kernel')->getRootDir() . '/../web/data/'.$calendar->getSlug().'.xml';
            file_put_contents($path,$rootNode->asXML());
        }

    }
}
