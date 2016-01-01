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
use AppBundle\Form\CalendarType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class CalendarController extends Controller
{
    public function indexAction(Request $request)
    {
        $calendars = $this->getDoctrine()
        ->getRepository('AppBundle:Calendar')->findAll();

        return $this->render('AppBundle:Admin/Calendar:index.html.twig', array(
            "calendars" => $calendars,
        ));
    }

    public function newAction(Request $request)
    {
        $calendar = new Calendar();

        $session = $request->getSession();

        $session->set('introduction', 'true');

        $form = $this->createForm(new CalendarType(), $calendar);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_teacher_index'));
        }


        return $this->render('AppBundle:Admin/Calendar:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function showAction(Request $request, $slug)
    {
        $event = new Event();

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Calendar')->findOneBy(array(
            'slug' => $slug
        ));

        $form = $this->createForm(new EventType(), $event);

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            $this->SerializeToXmlAction($entity);
        }
        //$this->SerializeToXmlAction($entity);

        return $this->render('AppBundle:Admin/Calendar:show.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));

    }

    public function serializeToXmlAction(Calendar $entity)
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

                    $tabTeachers[$subjects[$i]->getName()][] = $teacher->getFirstname();

                }
            }
        }

        $query =  $this->getDoctrine()->getRepository('AppBundle:Event')->findCalendarEvents($entity);

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

        $path = $this->get('kernel')->getRootDir() . '/../web/data/'.$entity->getSlug().'.xml';

        file_put_contents($path,$rootNode->asXML());

        return array();
    }

    public function editAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Calendar')->findOneBy(array(
            'slug' => $slug,
        ));

        $editForm = $this->createForm(new CalendarType(), $entity);
        $editForm->handleRequest($request);

        $events = $em->getRepository('AppBundle:Event')->findCalendarEvents($entity);

        if($editForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_calendar_index'));
        }

        return $this->render('AppBundle:Admin/Calendar:edit.html.twig', array(
           'edit_form'   => $editForm->createView(),
           'entity' => $entity,
           'events' => $events,
        ));
    }

}
