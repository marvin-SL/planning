<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Calendar;
use AppBundle\Entity\Classroom;
use AppBundle\Entity\Teacher;
use AppBundle\Entity\Subject;
use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Symfony\Component\HttpFoundation\Response;




class CalendarController extends Controller
{

    public function newAction(Request $request)
    {
        $calendar = new Calendar();

        $form = $this->createForm(new CalendarType(), $calendar);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();
        }

        return $this->render('AppBundle:Admin/Calendar:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function showAction(Request $request)
    {
        $event = new Event();

        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            $this->SerializeToXmlAction();
        }

        return $this->render('AppBundle:Admin/Calendar:show.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function serializeToXmlAction()
    {
        $subjectRepository = $this->getDoctrine()
        ->getRepository('AppBundle:Subject');
        $subjects = $subjectRepository->findAll();

        $eventRepository = $this->getDoctrine()
            ->getRepository('AppBundle:Event');

        $tabTeachers = [];

        for($i = 0; $i < sizeof($subjects); $i++){
            $tabTeachers[]=$subjects[$i]->getName();
            foreach ($subjects[$i]->getTeachers() as $teacher)
            {

                for($y = 0; $y < sizeof($subjects[$i]); $y++)
                {

                    $tabTeachers[$subjects[$i]->getName()][] = $teacher->getFirstName();

                }
            }
        }

        $query = $eventRepository->createQueryBuilder ( 'e' )->getQuery ()->getResult ();

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
        }

        $eventRepository = $this->getDoctrine()
        ->getRepository('AppBundle:Event');

        $eventList = $eventRepository->findAll();

        $path = $this->get('kernel')->getRootDir() . '/../web/data/events.xml';

        file_put_contents($path,$rootNode->asXML());

        return array();
    }

}
