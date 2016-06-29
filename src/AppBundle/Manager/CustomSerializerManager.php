<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Event;
use AppBundle\Entity\Calendar;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 *  CustomSerializer manager.
 */
class CustomSerializerManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }

    public function serialize(Calendar $calendar, $deleteCalendar = false)
    {

        $fs = new Filesystem();

        $subjects = $this->em->getRepository('AppBundle:Subject')->findAll();
        $tabTeachers = [];

        if ($deleteCalendar == false) {
            for ($i = 0; $i < sizeof($subjects); ++$i) {
                $tabTeachers[] = $subjects[$i]->getName();
                foreach ($subjects[$i]->getTeachers() as $teacher) {

                    for ($y = 0; $y < sizeof($subjects[$i]); ++$y) {

                        $tabTeachers[$subjects[$i]->getName()][] = $teacher->getLastname();

                    }
                }
            }


            $query = $this->em->getRepository('AppBundle:Event')->findCalendarEvents($calendar);
            $rootNode = new \SimpleXMLElement('<data></data>');

            if (!$fs->exists($this->container->get('kernel')->getRootDir().'/../web/data/')) {
                try {
                    $fs->mkdir($this->container->get('kernel')->getRootDir().'/../web/data/', 0775);
                } catch (IOExceptionInterface $e) {
                    echo 'An error occurred while creating your directory at '.$e->getPath();
                }
                //mkdir($this->container->get('kernel')->getRootDir().'/../web/data/', 0775, true);
            }

            foreach ($query as $eventList) {
                $eventNode = $rootNode->addChild('event');
                $eventNode->addChild('id', $eventList->getId());
                $eventNode->addChild('calendar', $eventList->getCalendar()->getTitle());
                $eventNode->addChild('start_date', $eventList->getStartDate()->format('Y-m-d H:i:s'));
                $eventNode->addChild('end_date', $eventList->getEndDate()->format('Y-m-d H:i:s'));
                $eventNode->addChild('classroom', $eventList->getClassroom()->getName());
                $eventNode->addChild('notice', $eventList->getNotice());
                if (isset($tabTeachers[$eventList->getSubject()->getName()])) {
                    $eventNode->addChild('subject', $eventList->getSubject()->getName().' | '.implode(',', $tabTeachers[$eventList->getSubject()->getName()]));
                }
                $eventNode->addChild('color', $eventList->getSubject()->getColor());

                $path = $this->container->get('kernel')->getRootDir().'/../web/data/'.$calendar->getSlug().'.xml';
                file_put_contents($path, $rootNode->asXML());
            }
        } elseif ($deleteCalendar == true) {

            try {
                $fs->remove(array('symlink', $this->container->get('kernel')->getRootDir().'/../web/data/'.$calendar->getSlug().'.xml', 'activity.log'));
            } catch (IOExceptionInterface $e) {
                echo 'An error occurred while deleting your directory at '.$e->getPath();
            }
        }
    }

    public function createEmptyXmlFile(Calendar $calendar)
    {
        $fs = new Filesystem();
        $rootNode = new \SimpleXMLElement('<data></data>');

        if (!$fs->exists($this->container->get('kernel')->getRootDir().'/../web/data/'.$calendar->getSlug().'.xml')) {

            try {
                $path = $this->container->get('kernel')->getRootDir().'/../web/data/'.$calendar->getSlug().'.xml';
                file_put_contents($path, $rootNode->asXML());
            } catch (IOExceptionInterface $e) {
                echo 'An error occurred while creating your directory at '.$e->getPath();
            }
            //mkdir($this->container->get('kernel')->getRootDir().'/../web/data/', 0775, true);
        }
        
    }
}
